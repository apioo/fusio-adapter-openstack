<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Fusio\Adapter\OpenStack\Connection;

use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\ParametersInterface;
use GuzzleHttp\ClientInterface;
use OpenStack\OpenStack;

/**
 * ConnectionAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
abstract class ConnectionAbstract implements ConnectionInterface
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory)
    {
        $builder->add($elementFactory->newInput('auth_url', 'Auth Url', ''));
        $builder->add($elementFactory->newInput('region', 'Region', ''));
        $builder->add($elementFactory->newInput('user_id', 'User Id', ''));
        $builder->add($elementFactory->newInput('user_password', 'User Password', ''));
        $builder->add($elementFactory->newInput('project_id', 'Project Id', ''));
    }

    /**
     * @param \GuzzleHttp\ClientInterface $httpClient
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param \Fusio\Engine\ParametersInterface $config
     * @return \OpenStack\OpenStack
     */
    protected function getOpenStack(ParametersInterface $config)
    {
        $options = [
            'authUrl' => $config->get('auth_url'),
            'region'  => $config->get('region'),
            'user'    => ['id' => $config->get('user_id'), 'password' => $config->get('user_password')],
            'scope'   => ['project' => ['id' => $config->get('project_id')]]
        ];

        if ($this->httpClient) {
            $options['httpClient'] = $this->httpClient;
        }

        return new OpenStack($options);
    }
}
