<?php

namespace skill\Skill;

use pocketmine\Player;

abstract class SkillBase implements SkillIds {

    public const SKILL_ID = -1;

    public const NONE = 0;
    public const HEALTH = 1;
    public const MANA = 2;

    /** @var string */
    public $name;

    /** @var string */
    public $explain;

    /** @var int */
    public $costType = self::NONE;

    /** @var int */
    public $cost = 0;

    /** @var Player */
    public $user;

    /** @var int */
    protected $cooldown = 0;

    /** @var int */
    protected $usedTime = 0;

    public function __construct(Player $user, string $skillName, string $skillExplain = '', int $cooldown = 0, int $costType = self::NONE, int $cost = 0) {
        $this-> setName($skillName);
        $this-> setExplain($skillExplain);
        $this-> setCooldown($cooldown);
        $this-> setCostType($costType);
        $this-> setCost($cost);
    }

    public function checkCooldown() : bool {
        return time() - $this-> getUsedTime() >= $this-> getCooldown();
    }

    public function isEnough() : bool {
        switch($this-> costType) {
            case self::NONE :
                return true;
            case self::HEALTH :
                return $this-> getUser()-> getHealth() - $this-> getCost() > 0;
            case self::MANA :
                return $this-> getUser()-> getMana() - $this-> getCost() >= 0;
            default :
                return false;
        }
    }

    public function getUser() : Player {
        return $this-> user;
    }

    public function cast() {
        if($this-> getUser()-> isOp()) {
            $this-> work();
            $this-> setUsedTime(time());
        }
        else {
            if($this-> checkCooldown() && $this-> isEnough()) {
                $this-> work();
                $this-> setUsedTime(time());
                switch($this-> costType) {
                    case self::HEALTH :
                        $this-> getUser()-> setHealth($this-> getUser()-> getHealth() - $this-> getCost());
                        break;
                    case self::MANA :
                        $this-> getUser()-> setMana($this-> getUser()-> getMana() - $this-> getCost());
                        break;
                    default :
                        break;
                }
            }
        }
    }

    abstract public function work();

    public function getName() : string {
        return $this-> name;
    }

    public function setName(string $skillName) {
        $this-> name = $skillName;
    }

    public function getExplain() : string {
        return $this-> explain;
    }

    public function setExplain(string $skillExplain) {
        $this-> explain = $skillExplain;
    }

    public function getCooldown() : int {
        return $this-> cooldown;
    }

    public function setCooldown(int $second) {
        $this-> cooldown = $second;
    }

    public function getUsedTime() : int {
        return $this-> usedTime;
    }

    public function setUsedTime(int $time) {
        $this-> usedTime = $time;
    }

    public function getCostType() : int {
        return $this-> costType;
    }

    public function setCostType(int $costType) {
        $this-> costType = $costType;
    }

    public function getCost() : int {
        return $this-> cost;
    }

    public function setCost(int $cost) {
        $this-> cost = $cost;
    }
}
