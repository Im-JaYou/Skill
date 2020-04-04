<?php
namespace skill\Skill;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\Player;
use skill\Skill\SkillBase;

class Attack extends SkillBase {

    public const SKILL_ID = self::ATTACK;

    /** @var int */
    public $damage = 0;

    /** @var Entity */
    public $target;

    public function __construct(Player $user, Entity $target, int $damage, string $skillName, string $skillExplain = '', int $cooldown = 0, int $costType = self::NONE, int $cost = 0) {
        parent::__construct($user, $skillName, $skillExplain, $cooldown, $costType, $cost);
        $this-> setDamage($damage);
        $this-> setTarget($target);
    }

    public function getDamage() : int {
        return $this-> damage;
    }

    public function setDamage(int $damage) {
        $this-> damage = $damage;
    }

    public function getTarger() : Entity {
        return $this-> target;
    }

    public function setTarget(Entity $target) {
        $this-> target = $target;
    }

    public function work() {
        $attack = new EntityDamageByEntityEvent($this-> getUser(), $this-> getTarger(), EntityDamageByEntityEvent::CAUSE_MAGIC, $this-> getDamage());
        $this-> target-> attack();
    }
}