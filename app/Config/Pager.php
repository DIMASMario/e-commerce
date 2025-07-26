<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Pager Templates
     * --------------------------------------------------------------------------
     *
     * This array holds the views used to render the pagination links.
     * You can easily add your own templates here and use them on
     * the fly, simply by referencing the key you use here.
     */
    public array $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
        'bootstrap_pager' => 'App\Views\pagers\bootstrap_pager', // <-- TAMBAHKAN BARIS INI
    ];

    /**
     * --------------------------------------------------------------------------
     * Items Per Page
     * --------------------------------------------------------------------------
     *
     * The default number of results shown in a single page.
     */
    public int $perPage = 20;
}
