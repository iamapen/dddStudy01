<?php
declare(strict_types=1);

namespace Acme\Shop\Test\SessionHandler;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;

/**
 * 配列に保存するもの
 *
 * 当然、本番環境では使えない
 */
class ArraySessionHandler extends AbstractSessionHandler
{
    private $data;

    public function __construct($data = '')
    {
        $this->data = $data;
    }

    public function open($path, $name)
    {
        echo __FUNCTION__, "\n";

        return parent::open($path, $name);
    }

    public function validateId($sessionId)
    {
        echo __FUNCTION__, "\n";

        return parent::validateId($sessionId);
    }

    /**
     * {@inheritdoc}
     */
    public function read($sessionId)
    {
        echo __FUNCTION__, "\n";

        return parent::read($sessionId);
    }

    /**
     * {@inheritdoc}
     */
    public function updateTimestamp($sessionId, $data)
    {
        echo __FUNCTION__, "\n";

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function write($sessionId, $data)
    {
        echo __FUNCTION__, "\n";

        return parent::write($sessionId, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($sessionId)
    {
        echo __FUNCTION__, "\n";

        return parent::destroy($sessionId);
    }

    public function close()
    {
        echo __FUNCTION__, "\n";

        return true;
    }

    public function gc($maxLifetime)
    {
        echo __FUNCTION__, "\n";

        return true;
    }

    protected function doRead($sessionId)
    {
        echo __FUNCTION__ . ': ', $this->data, "\n";

        return $this->data;
    }

    protected function doWrite($sessionId, $data)
    {
        echo __FUNCTION__ . ': ', $data, "\n";

        return true;
    }

    protected function doDestroy($sessionId)
    {
        echo __FUNCTION__, "\n";

        return true;
    }
}
