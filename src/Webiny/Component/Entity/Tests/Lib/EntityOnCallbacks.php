<?php
namespace Webiny\Component\Entity\Tests\Lib;

use Webiny\Component\Entity\EntityAbstract;
use Webiny\Component\Entity\Tests\Lib\Classes;

/**
 * Class Entity
 *
 * This class tests all validators except 'required' on relevant attribute types
 *
 * @package Webiny\Component\Entity\Tests\Lib
 */
class EntityOnCallbacks extends EntityAbstract
{
    protected static $entityCollection = "OnCallbacks_Entity";

    protected function entityStructure()
    {
        $this->attr('char')->char()->setAfterPopulate()->onSet(function ($value) {
            return 'set-' . $this->number . '-' . $value;
        })->onGet(function ($value) {
            return 'get-' . $value;
        })->onToArray(function () {
            return ['key' => 'value'];
        })->onToDb(function ($value) {
            return 'db-' . $value;
        });
        $this->attr('number')->integer();
    }
}