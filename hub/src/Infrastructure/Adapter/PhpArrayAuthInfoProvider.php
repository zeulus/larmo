<?php

namespace FP\Larmo\Infrastructure\Adapter;

use FP\Larmo\Domain\Service\AuthInfoInterface;

/**
 * Class PhpArrayAuthInfoProvider
 *
 * This class validates agents using credentials stored in PHP array.
 * Contents of the array should have following structure:
 * <code>
 *   $authInfo = [
 *     'githubAgent' => 'y9j8KhXR{DD_D$TbebW_P{lderrxECSr',
 *     'bitbucketAgent' => '[dN#2ji-Zsp|!XXqr0&-?|9txHla0aaU9r&'
 *   ]
 * </code>
 *
 * @package FP\Larmo\Infrastructure\Adapter
 */
class PhpArrayAuthInfoProvider implements AuthInfoInterface
{
    protected $vault = [];

    public function __construct(array $vault)
    {
        $this->vault = $vault;
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
