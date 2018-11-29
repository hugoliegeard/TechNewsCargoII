<?php

namespace App\Article\Provider;


use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlProvider
{
    /**
     * Retourner les articles de articles.yaml
     * sous forme de tableau.
     */
    public function getArticles()
    {
        try {
            return Yaml::parseFile(__DIR__ . '/articles.yaml')['data'];
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML file: %s', $exception->getMessage());
        }
    }
}