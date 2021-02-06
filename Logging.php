<?php

/**
 * @name Logging
 * @main DINO\Logging
 * @author DINO
 * @api 3.0.0
 * @version 1
 */

//해당 플러그인은 Maru님의 MineSponge의 아이디어를 참고하여 제작되었습니다.

namespace DINO;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\block\Block;


class Logging extends PluginBase
{
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new LoggingListener($this),$this);
    }
    public function getBlock()
    {
        $random = mt_rand(1,601);
        if($random > 1 && $random <= 100)
        {
            return Block::get(17,0);
        }
        if($random > 100 && $random <= 200)
        {
            return Block::get(17,1);
        }
        if($random > 200 && $random <= 300)
        {
            return Block::get(17,2);
        }
        if($random > 300 && $random <= 400)
        {
            return Block::get(17,3);
        }
        if($random > 400 && $random <= 500)
        {
            return Block::get(162,0);
        }
        if($random > 500 && $random <= 600)
        {
            return Block::get(162,1);
        }
        return Block::get(241,4);
    }
}

class LoggingListener implements Listener
{
    public function __construct(Logging $owner)
    {
        $this->owner = $owner;
    }
    public function onBlockPlace(BlockPlaceEvent $event)
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        if($block->getId() === 101)
        {
            $block->getLevel()->setBlock(new Vector3($block->getX(),$block->getY()+1,$block->getZ()),$this->owner->getBlock());
        }
    }
    public function onBlockBreak(BlockBreakEvent $event)
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        if($block->getLevel()->getBlock(new Vector3($block->getX(),$block->getY()-1,$block->getZ()))->getId() === 101)
        {
            $event->setCancelled();
            $block->getLevel()->setBlock($block->asVector3(),$this->owner->getBlock());
            if($block->getId() === 17 && $block->getDamage() === 0)
            {
                $item = Item::get(5,0);
                $item->setCustomName('§r§f깔끔한 참나무 판자');
                $player->getInventory()->addItem($item);
            }
            if($block->getId() === 17 && $block->getDamage() === 1)
            {
                $item = Item::get(5,1);
                $item->setCustomName('§r§f깔끔한 가문비나무 판자');
                $player->getInventory()->addItem($item);
            }
            if($block->getId() === 17 && $block->getDamage() === 2)
            {
                $item = Item::get(5,2);
                $item->setCustomName('§r§f깔끔한 자작나무 판자');
                $player->getInventory()->addItem($item);
            }
            if($block->getId() === 17 && $block->getDamage() === 3)
            {
                $item = Item::get(5,3);
                $item->setCustomName('§r§f깔끔한 정글나무 판자');
                $player->getInventory()->addItem($item);
            }
            if($block->getId() === 162 && $block->getDamage() === 0)
            {
                $item = Item::get(5,4);
                $item->setCustomName('§r§f깔끔한 아카시아나무 판자');
                $player->getInventory()->addItem($item);
            }
            if($block->getId() === 162 && $block->getDamage() === 1)
            {
                $item = Item::get(5,5);
                $item->setCustomName('§r§f깔끔한 짙은 참나무 판자');
                $player->getInventory()->addItem($item);
            }
            if($block->getId() === 241 && $block->getDamage() === 4)
            {
                $item = Item::get(736,0);
                $item->setCustomName('§r§e영롱한 벌집');
                $player->getInventory()->addItem($item);
                $player->sendTitle('§r§e희귀','§r§f영롱한 벌집을 획득했습니다',10,10,10);
            }
        }
    }
}