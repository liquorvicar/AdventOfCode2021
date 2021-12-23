<?php

namespace AdventOfCode\Day16;

class Packet
{
    private $isComplete = false;
    private $type = '';
    private $version = '';
    private $value;
    private $subPackets = [];
    private $mode = 'version';
    private $group = '';
    private $valueBin = '';
    private $subPacketMode = 'new';
    private $subPacketLength = 0;
    private $subPacket;

    public function addBit($bit)
    {
        switch ($this->mode) {
            case 'version':
                $this->version.= $bit;
                if (strlen($this->version) === 3) {
                    $this->version = bindec($this->version);
                    $this->mode = 'type';
                }
                break;
            case 'type':
                $this->type.= $bit;
                if (strlen($this->type) === 3) {
                    $this->type = bindec($this->type);
                    $this->mode = $this->type === 4 ? 'value' : 'sub-packets';
                }
                break;
            case 'value':
                $this->group.= $bit;
                if (strlen($this->group) === 5) {
                    $this->valueBin .= substr($this->group, 1);
                    if (substr($this->group, 0, 1) === '0') {
                        $this->value = bindec($this->valueBin);
                        $this->valueBin = '';
                        $this->isComplete = true;
                    }
                    $this->group = '';
                }
                break;
            case 'sub-packets':
                switch ($this->subPacketMode) {
                    case 'new':
                        if ($bit === '0') {
                            $this->subPacketMode = 'bits';
                        } else {
                            $this->subPacketMode = 'packets';
                        }
                        break;
                    case 'bits':
                        if ($this->subPacketLength === 0) {
                            $this->group .= $bit;
                            if (strlen($this->group) === 15) {
                                $this->subPacketLength = bindec($this->group);
                            }
                        } else {
                            $this->valueBin .= $bit;
                            if (strlen($this->valueBin) === $this->subPacketLength) {
                                $subPacket = new Packet();
                                foreach (str_split($this->valueBin) as $subBit) {
                                    $subPacket->addBit($subBit);
                                    if ($subPacket->isComplete()) {
                                        $this->subPackets[] = $subPacket;
                                        $subPacket = new Packet();
                                    }
                                }
                                $this->isComplete = true;
                            }
                        }
                        break;
                    case 'packets':
                        if ($this->subPacketLength === 0) {
                            $this->group .= $bit;
                            if (strlen($this->group) === 11) {
                                $this->subPacketLength = bindec($this->group);
                            }
                        } else {
                            if (!$this->subPacket) {
                                $this->subPacket = new Packet();
                            }
                            $this->subPacket->addBit($bit);
                            if ($this->subPacket->isComplete()) {
                                $this->subPackets[] = $this->subPacket;
                                $this->subPacket = new Packet();
                                if (count($this->subPackets) === $this->subPacketLength) {
                                    $this->isComplete = true;
                                }
                            }
                        }
                        break;
                }
        }
    }

    public function isComplete()
    {
        return $this->isComplete;
    }

    public function toArray()
    {
        $packet = [
            'version' => $this->version,
            'type' => $this->type,
        ];
        if ($this->value) {
            $packet['value'] = $this->value;
        } else {
            $packet['sub-packets'] = array_map(function ($packet) {
                return $packet->toArray();
            }, $this->subPackets);
        }
        return $packet;
    }
}