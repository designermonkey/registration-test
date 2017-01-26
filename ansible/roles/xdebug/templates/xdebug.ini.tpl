zend_extension=xdebug.so

xdebug.default_enable = '1'
xdebug.remote_autostart = '0'
xdebug.remote_connect_back = '1'
xdebug.remote_enable = '1'
xdebug.remote_handler = dbgp
xdebug.remote_port = '9000'
xdebug.var_display_max_children = {{ xdebug.display_max_children }}
xdebug.var_display_max_data = {{ xdebug.display_max_data }}
xdebug.var_display_max_depth = {{ xdebug.display_max_depth }}
