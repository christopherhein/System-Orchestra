<?php
/**
* Application Templating
*
* Setting up the Rendering for the templates.
*
* Licensed under the MIT license.
*
* @category   Orchestra
* @copyright  Copyright (c) 2010, Christopher Hein
* @license    http://orchestramvc.chrishe.in/license
* @version    Release: 0.0.1:beta
* @link       http://orchestramvc.chrishe.in/docs/lib/controllers/application/
*
*/
class Template {
	protected $_variables = array();
	protected $_controller;
	protected $_action;
	protected $_haml;
	protected $_javascripts = array();
	protected $_stylesheets = array();
	public $params = array();
	
	public function __construct($controller, $action) {
		$this->_controller = $controller;
		$this->_action = $action;
		$this->set($controller, array());
		$this->set(trim($controller,"s"), array());
	}
	
	public function __call($name, $arguments) {
 	  global $core;
 	  extract($core);
 	  
    if (substr($name, -5) == '_path') {
      return $paths->$name($arguments);
    }
  }

	public function set($name, $value) {
		$this->_variables[$name] = $value;
		$this->params[$name] = $value;
	}
	
	public function format($format, $content, $file = NULL) {
		switch($format) {
			case 'json':
				$this->_variables['render'] = 'formatted';
				header('Content-type: application/json');
				$this->generate_format($format, $content, $file);
			break;
			case 'xml':
				$this->_variables['render'] = 'formatted';
				header('Content-type: text/xml');
				$this->generate_format($format, $content, $file);
			break;
			case 'rss':
				$this->_variables['render'] = 'formatted';
				header('Content-type: text/rss+xml');
				$this->generate_format($format, $content, $file);
			break;
			case 'atom':
				$this->_variables['render'] = 'formatted';
				header('Content-type: text/atom+xml');
				$this->generate_format($format, $content, $file);
			break;
			case 'csv':
				$this->_variables['render'] = 'formatted';
				header('Content-Type: application/vnd.ms-excel');
				$this->generate_format($format, $content, $file);
			break;
			case 'pdf':
				$this->_variables['render'] = 'formatted';
				header('Content-Type: application/pdf');
				$this->generate_format($format, $content, $file);
			break;
			case 'css':
				$this->_variables['render'] = 'formatted';
				header('Content-Type: text/css');
				$this->generate_format('pcss', $content, $file);
			break;
			case 'js':
				$this->_variables['render'] = 'formatted';
				header('Content-Type: text/javascript');
				$this->generate_format('pjs', $content, $file);
			break;
			default:
			break;
		}
	}
	
	public function content($contents = array()) {
		$i = 0;
		while(list($k, $v) = each($contents)) {
			switch($k) {
				case 'js':
				case 'javascript':
				case 'javascripts':
					$this->_javascripts[] = $v;
				break;
				case 'css':
				case 'stylesheet':
				case 'stylesheets':
					$this->_stylesheets[] = $v;
				break;
			}
			$i++;
		}
	}
	
	public function javascripts() {
		foreach($this->_javascripts as $js) {
			return $js;
		}
	}
	
	public function stylesheets() {
		foreach($this->_javascripts as $styles) {
			return $styles;
		}
	}

  function render($render = "application") {
    global $core;
		extract($core);
		extract($this->_variables);
		
    if($render == "" || $render == "application") {
     	if(file_exists(VIEWS.'layouts'.DS.'application.html.orc') || file_exists(VIEWS.'layouts'.DS.'application.html.haml')) {
     	  if($app['haml'] == true) {
					$this->haml_parse(array($core, $this->_variables));
					echo $haml->setFile(VIEWS.'layouts'.DS.'application.html.haml');
				} else {
					extract($core);
					extract($this->_variables);
					include(VIEWS.'layouts'.DS.'application.html.orc');
				}
    	}
    } elseif($render == "none") {
      $this->yield();
    } elseif($render == "formatted") {
	
		}
  }
  
  public function yield() {
    global $core;
		extract($core);
		extract($this->_variables);
		
		if(file_exists(VIEWS.$this->_controller . DS . $this->_action . '.html.orc') || file_exists(VIEWS.$this->_controller . DS . $this->_action . '.html.haml')) {
			if($app['haml'] == true) {
				$this->haml_parse(array($core, $this->_variables));
				echo $haml->setFile(VIEWS.$this->_controller . DS . $this->_action . '.html.haml');
			} else {
				extract($core);
				extract($this->_variables);
				include(VIEWS.$this->_controller . DS . $this->_action . '.html.orc');
			}
    } else if($this->_action == "" ) {
      if(file_exists(VIEWS.$this->_controller . DS . 'index.html.orc') || file_exists(VIEWS.$this->_controller . DS . 'index.html.haml')) {
	      if($app['haml'] == true) {
					$this->haml_parse(array($core, $this->_variables));
					echo $haml->setFile(VIEWS.$this->_controller . DS . 'index.html.haml');
				} else {
					extract($core);
					extract($this->_variables);
					include(VIEWS.$this->_controller . DS . 'index.html.orc');
				}
      }
    }
  }

	public function partial($file, $options = array()) {
  	global $core;
		extract($core);
		extract($this->_variables);
		extract($options);
		
		$sep = explode('/', $file);
		include('../app/views/'.$sep[0].'/_'.$sep[1].'.html.orc');
	}
	
	public function haml_parse($vars = array()) {
		global $core;
		extract($core);
		foreach($vars as $var) {
			while(list($k, $v) = each($var)) {
				$haml->assign($k, $v);
			}
		}
		$haml->assign('views', $this);
	}
	
	public function generate_format($format, $content, $file = NULL) {
		if(file_exists(VIEWS.$this->_controller . DS . $this->_action . '.'.$format.'.orc')) {
			include(VIEWS.$this->_controller . DS . $this->_action . '.'.$format.'.orc');
		} elseif(file_exists(VIEWS.$this->_controller . DS . $this->_action . '.'.$format)) {
			include(VIEWS.$this->_controller . DS . $this->_action . '.'.$format);
		} elseif(file_exists(VIEWS.$file.'.'.$format.'.orc')) {
			include(VIEWS.$file.'.'.$format.'.orc');
		}	elseif(file_exists(VIEWS.$file.'.'.$format)) {
			include(VIEWS.$file.'.'.$format);
		} elseif(file_exists(APP.'stylesheets/'.$this->_controller.'.css.'.$format)) {
			include(APP.'stylesheets/'.$this->_controller.'.css.'.$format);
		} elseif(file_exists(APP.'stylesheets/'.$this->_controller.'.'.$format)) {
			include(APP.'stylesheets/'.$this->_controller.'.'.$format);
		} elseif(file_exists(APP.'stylesheets/'.$file.'.css.'.$format)) {
			include(APP.'stylesheets'.$file.'.css.'.$format);
		}	elseif(file_exists(APP.'stylesheets/'.$file.'.'.$format)) {
			include(APP.'stylesheets'.$file.'.'.$format);
		} elseif(file_exists(VIEWS.$this->_controller . DS . $this->_action . '.js.'.$format)) {
			include(VIEWS.$this->_controller . DS . $this->_action . '.js.'.$format);
		} elseif(file_exists(VIEWS.$this->_controller . DS . $this->_action . '.js')) {
			include(VIEWS.$this->_controller . DS . $this->_action . '.js');
		} else {
			switch($format) {
				case 'json':
					echo json_encode($content);
				break;
				case 'xml':
					$xml = new array2xml('api');
			    $xml->createNode( $content );
			    echo $xml;
				break;
				case 'rss':
					echo "<rss></rss>";
				break;
				case 'csv':
					while ($value = current($content[0][key($content[0])])) {
				    if ($value != NULL) {
			        echo '"'.key($content[0][key($content[0])]).'",';
				    }
				    next($content[0][key($content[0])]);
					}
					echo "\n";
					foreach($content as $con) {
						foreach($con as $co) {
							foreach($co as $c) {
								echo '"'.$c.'",';
							}
						}
						echo "\n";
					}
				break;
				case 'pdf':
					echo "pdf";
				break;
				default:
				break;
			}	
		}
	}
	
}