<?php

namespace Slim\View;

class Smarty extends \Slim\View
{
    /**
     * The base template directory
     * @var string
     */
    protected $template_dir;

    /**
     * The directory in which to compile the templates
     * @var string
     */
    protected $compile_dir;

    /**
     * The directory in which to cache the compiled templates
     * @var string
     */
    protected $cache_dir;

    /**
     * The directory containing Smarty plugins
     * @var string
     */
    protected $plugin_dir;

    /**
     * The smarty instance
     * @var \Smarty
     */
    protected $smarty;

    /**
     * Constructor
     *
     * @param string $template_dir The base template directory
     * @param string $compile_dir  The directory in which to compile the templates
     * @param string $cache_dir    The directory in which to cache the compiled templates
     * @param string $plugin_dir   The directory containing Smarty plugins
     */
    public function __construct($template_dir, $compile_dir, $cache_dir, $plugin_dir = '')
    {
        parent::__construct();

        $this->template_dir = $template_dir;
        $this->compile_dir = $compile_dir;
        $this->cache_dir = $cache_dir;
        $this->plugin_dir = $plugin_dir;
    }

    /**
     * Returns the cached smarty instance or creates and caches a new instance
     *
     * Not every Slim route will use Smarty, so by implementing this function,
     * we save those routes from having unnecessary overhead.
     *
     * @return \Smarty
     */
    protected function getSmartyInstance()
    {
        if ($this->smarty) {
            return $this->smarty;
        }

        $smarty = new \Smarty();
        $smarty->setTemplateDir($this->template_dir);
        $smarty->setCompileDir($this->compile_dir);
        $smarty->setCacheDir($this->cache_dir);
        $smarty->setErrorReporting(0);

        if ($this->plugin_dir) {
            $smarty->addPluginsDir($this->plugin_dir);
        }

        return $this->smarty = $smarty;
    }

    /**
     * Assign variables using smarty's API
     *
     * @param  array|string $var   The template variable name(s)
     * @param  mixed        $value The value to assign
     * @return \Slim\View\Smarty
     */
    public function assign($var, $value = null)
    {
        if (is_array($var)) {
            foreach ($var as $name => $value) {
                $this->set($name, $value);
            }
        } else {
            $this->set($var, $value);
        }

        return $this;
    }

    /**
     * Renders the template file with the associated data
     *
     * @param  string $template The template pathname, relative to the template base directory
     * @param  array  $data     Any additonal data to be passed to the template
     * @return string
     */
    protected function render($template, $data = null)
    {
        $data = $data? array_merge($this->all(), (array)$data): $this->all();
        $smarty = $this->getSmartyInstance();

        return $smarty->fetch($template, $data);
    }
}
