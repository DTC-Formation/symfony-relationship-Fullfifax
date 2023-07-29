<?php

namespace App\Helper;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonResponseHelper {

    public function configureSerializer(array $groups): Serializer
    {
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::GROUPS => $groups,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object): string {
                return $object->getId();
            }
        ];

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader());
        $objectNormalizer = new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext);
        $normalizer = [new DateTimeNormalizer(), $objectNormalizer];

        return new Serializer($normalizer, [$encoder]);

    }

    public function serializeData(array $data, array $groups = ['default']): array
    {
        return json_decode($this->configureSerializer($groups)->serialize($data, 'json'));
    }

}