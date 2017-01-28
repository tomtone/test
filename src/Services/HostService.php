<?php
namespace Neusta\MageHost\Services;

use Neusta\MageHost\Services\Provider\Filesystem;

class HostService
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fs;

    /**
     * scope to interact with.
     *
     * @var string
     */
    private $_scope = null;

    /**
     * HostService constructor.
     */
    public function __construct(Filesystem $fs = null)
    {
        //@codeCoverageIgnoreStart
        if(is_null($fs)){
            $fs = new Filesystem();
        }
        //@codeCoverageIgnoreEnd
        $this->fs = $fs;
    }

    /**
     * Add given configuration to .magehost file.
     *
     * @param $name
     * @param $host
     * @param $user
     * @param string $scope
     */
    public function update($name, $host, $user, $scope = 'local')
    {
        $config = [
            'name' => $name,
            'host' => $host,
            'user' => $user,
            'port' => 22
        ];

        $this->fs->addHostToConfiguration($config, $this->_scope);
    }


    public function getHosts($scope)
    {
        switch ($scope){
            case 'local':
                $config = $this->fs->getLocalConfiguration();
                break;
            case 'project':
                $config = $this->fs->getProjectConfiguration();
                break;
            default:
                $local = $this->fs->getLocalConfiguration();
                $project = $this->fs->getProjectConfiguration();
                $global = $this->fs->getGlobalConfiguration();
                $config = array_merge($local, $project, $global);
                break;
        }
        return $config;
    }

    public function getHostsForQuestionhelper()
    {
        $config = $this->getHosts($this->_scope);
        $hosts = [];
        foreach ($config as $host) {
            $hosts[] = $host['name'];
        }
        return $hosts;
    }

    public function getConnectionStringByName($host)
    {
        $config = $this->getHosts($this->_scope);

        $hostKey = array_search($host, array_column($config, 'name'));

        $sshCommand = $config[$hostKey]['user'] . '@' . $config[$hostKey]['host'];

        return $sshCommand;
    }

    public function setScope($scope)
    {
        $this->_scope = $scope;
    }
}