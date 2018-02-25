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

namespace Fusio\Adapter\OpenStack\Tests\Connection;

use Fusio\Adapter\OpenStack\Connection\ConnectionAbstract;
use Fusio\Engine\Parameters;
use Fusio\Engine\Test\EngineTestCaseTrait;
use GuzzleHttp\Client;

/**
 * ApiTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
abstract class ApiTestCase extends \PHPUnit_Framework_TestCase
{
    use EngineTestCaseTrait;

    protected function getConnection($class)
    {
        /** @var ConnectionAbstract $connectionFactory */
        $connectionFactory = $this->getConnectionFactory()->factory($class);

        $config = new Parameters([
            'auth_url'      => 'http://example.org:8080/v1/AUTH_e00abf65afca49609eedd163c515cf10',
            'region'        => '{region}',
            'user_id'       => '{userId}',
            'user_password' => '{password}',
            'project_id'    => '{projectId}',
        ]);

        // set a custom http client so that we dont call the auth url
        $connectionFactory->setHttpClient(new Client());

        return $connectionFactory->getConnection($config);
    }
}
