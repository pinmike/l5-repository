<?php
namespace Prettus\Repository\Events;

/**
 * Class RepositoryFlush
 * @package Prettus\Repository\Events
 */
class RepositoryFlush extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "flush";
}
