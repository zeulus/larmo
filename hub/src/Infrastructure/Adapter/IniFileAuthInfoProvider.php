<?php

namespace FP\Larmo\Infrastructure\Adapter;

use FP\Larmo\Domain\Service\AuthInfoInterface;
use FP\Larmo\Domain\Exception\AuthInitException;

/**
 * Class IniFileAuthInfoProvider
 *
 * This class validates agents using credentials stored in ini file.
 * If ini file is not valid or doesn't exists, AuthInitException will be thrown.
 * Data format required to validate:
 * <code>
 *   $authInfo = [
 *     'agent' => 'your_agent_id',
 *     'auth' => 'agent_hash_key'
 *   ]
 * </code>
 *
 * Contents of the file should have following structure:
 * <code>
 * [authInfo]
 * githubAgent = "y9j8KhXR{DD_D$TbebW_P{lderrxECSr"
 * githubAgent2 = "XK<b/g]7c$<g`kj.upU8xK,4=mCS"
 * bitbucketAgent = "[dN#2ji-Zsp|!XXqr0&-?|9txHla0aaU9r&"
 * skypeAgent = "@G5,Mrzox6gPCbxf9wCaZG>a#"
 * </code>
 *
 * @package FP\Larmo\Infrastructure\Adapter
 */
class IniFileAuthInfoProvider implements AuthInfoInterface
{

    /**
     * @var array
     */
    private $vault;

    /**
     * Interceptor for PHP warnings.
     *
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     *
     * @throws \ErrorException
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    /**
     * Reads users auth info db from ini file.
     *
     * @param string $file_path
     * @throws AuthInitException
     */
    public function __construct($file_path)
    {
        $config = false;

        if (is_readable($file_path)) {
            set_error_handler(array($this, 'errorHandler'));
            try {
                $config = parse_ini_file($file_path, true);
            } catch (\ErrorException $e) {
                throw new AuthInitException('Cannot parse auth file', $e->getCode(), $e);
            } finally {
                restore_error_handler();
            }
        }

        if ($config === false) {
            throw new AuthInitException('Cannot parse auth file');
        }

        if (!array_key_exists('authInfo', $config)) {
            throw new AuthInitException('Cannot find authInfo section');
        }

        $this->vault = $config['authInfo'];
    }

    /**
     * Validates auth info
     *
     * Function expects array in the form of:
     *   ['agent' => 'agentId', 'auth' => 'authKey']
     *
     * @param array $authInfo
     * @return bool
     */
    public function validate($authInfo)
    {
        if (!is_array($authInfo) || !array_key_exists('agent', $authInfo) || !array_key_exists('auth', $authInfo)) {
            return false;
        }

        if (array_key_exists($authInfo['agent'],
                $this->vault) && $this->vault[$authInfo['agent']] === $authInfo['auth']
        ) {
            return true;
        }

        return false;
    }
}
