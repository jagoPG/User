<?php

/*
 * This file is part of the BenGorUser package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BenGorUser\User\Application\Service\ChangePassword;

use BenGorUser\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGorUser\User\Domain\Model\User;
use BenGorUser\User\Domain\Model\UserRepository;
use BenGorUser\User\Domain\Model\UserToken;

/**
 * By request remember password specification of change user password command handler.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ByRequestRememberPasswordChangeUserPasswordSpecification implements ChangeUserPasswordSpecification
{
    /**
     * The user repository.
     *
     * @var UserRepository
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param UserRepository $aRepository The user repository
     */
    public function __construct(UserRepository $aRepository)
    {
        $this->repository = $aRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function user(ChangeUserPasswordCommand $aCommand)
    {
        $user = $this->repository->userOfRememberPasswordToken(
            new UserToken($aCommand->rememberPasswordToken())
        );
        if (null === $user) {
            throw new UserDoesNotExistException();
        }

        return $user;
    }
}