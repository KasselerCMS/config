Initialization Yaml configuration
$config = new Repository(new YamlFileReader(), new YamlFileWriter(), __DIR__.'/app/config/');

Initialization XML configuration
$config = new Repository(new XmlFileReader(), new XmlFileWriter(), __DIR__.'/app/config/');

Initialization JSON configuration
$config = new Repository(new JsonFileReader(), new JsonFileWriter(), __DIR__.'/app/config/');

Initialization PHP array configuration
$config = new Repository(new ArrayFileReader(), new ArrayFileWriter(), __DIR__.'/app/config/');


$config
    ->set('database.host', 'localhost')
    ->set('database.user', 'root')
    ->set('database.password', '')
    ->set('database.database', 'config')
    ->write();
    
$config->get('database.host');
