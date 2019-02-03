<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 03.02.19
 * Time: 17:17
 */

namespace App\Services;

/**
 * Class WinResultHelper
 * @package App\Services
 */
class WinResultHelper
{
    /**
     * @var string
     */
    protected $viewName;

    /**
     * @var array
     */
    protected $data;

    /**
     * WinResultHelper constructor.
     * @param string $viewName
     * @param array $data
     */
    public function __construct(string $viewName, array $data)
    {
        $this->viewName = $viewName;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getViewName(): string
    {
        return $this->viewName;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}