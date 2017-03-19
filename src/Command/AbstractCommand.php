<?php
/**
 * This file is part of the teamneusta/hosts project.
 * Copyright (c) 2017 neusta GmbH | Ein team neusta Unternehmen
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 *
 */

namespace Neusta\Hosts\Command;

use Neusta\Hosts\Services\HostService;
use Neusta\Hosts\Services\Provider\Cli;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

/**
 * Class AbstractCommand
 * @codeCoverageIgnore
 * @package Neusta\Hosts\Command
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var HostService
     */
    protected $_hostService;

    /**
     * @var Cli
     */
    protected $_cli;

    /**
     * Constructor.
     *
     * @param string|null $name The name of the command; passing null means it must be set in configure()
     *
     * @param HostService $hostService
     * @param Cli $cli
     */
    public function __construct($name = null, HostService $hostService = null, Cli $cli = null)
    {
        parent::__construct($name);
        if (is_null($hostService)) {
            $hostService = new HostService();
        }
        if (is_null($cli)) {
            $cli = new Cli();
        }
        $this->_cli = $cli;
        $this->_hostService = $hostService;
    }
}