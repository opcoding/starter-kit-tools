{
    "name": "%%composer.project.name%%",
    "description": "%%composer.project.description%%",
    "require": {
        "php": ">=7.0",
        "objective-php/application": "^1.1.0",
        "objective-php/router": "^1.0.0",
        "doctrine/annotations": "~1.4.0",
        "objective-php/services-factory": "^1.2.0",
        "twbs/bootstrap": "^3.3"
    },
    "autoload": {
        "psr-4": {
            "%%namespace.project%%": "app/src"
        }
    },
    "scripts": {
        "post-create-project-cmd" : [
            "Opcoding\\StarterKit\\Tools\\ComposerScript::exec",
            "Opcoding\\StarterKit\\Tools\\DockerScript::exec",
            "Opcoding\\StarterKit\\Tools\\DefaultFileScript::exec",
            "composer dump-autoload"
        ]
    }
}

