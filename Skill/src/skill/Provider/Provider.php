<?php

namespace skill\Provider;

use pocketmine\Player;
use skill\SKillAPI;

interface Provider {
    public function __construct(SKillAPI $plugin);

    /**
     * 플레이어의 존재 여부 반환
     *
     * @param Player $player
     * @return bool
     */
    public function playerExists(Player $player) : bool;

    /**
     * 새로운 플레이어 데이터 생성
     *
     * @param Player $player
     * @return bool
     */
    public function createPlayerData(Player $player) : bool;

    /**
     * 기존의 플레이어 데이터 제거
     *
     * @param Player $player
     * @return bool
     */
    public function removePlayerData(Player $player) : bool;

    /**
     * 플레이어의 클래스를 반환
     *
     * @param Player $player
     * @return string
     */
    public function getClass(player $player) : string;

    /**
     * 플레이어의 클래스를 설정
     *
     * @param Player $player
     * @param string $class
     * @return bool
     */
    public function setClass(Player $player, string $class = '모험가') : bool;

}