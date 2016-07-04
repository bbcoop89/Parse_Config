<?php


namespace ParseConfig\Mappers;


use ParseConfig\Entities\Configuration;

/**
 * Class ConfigurationMapper
 * @package ParseConfig\Mappers
 */
class ConfigurationMapper
{
    /**
     * @param Configuration[] $configurations
     */
    public function saveAll(array $configurations) {
        /*
         * start database transaction
         *
         * try {
         * $entityManager->getConnection()->beginTransaction();
         * OR
         * $pdoObject->beginTransaction();
         */

        foreach($configurations as $configuration) {
            /*
             * Persist entities with
             * $entityManager->persist($configuration);
             * OR
             * $sql = "INSERT INTO configuration (key, value) VALUES (:key, :value)"
             * $stmt = $pdoObject->prepare($sql);
             * $stmt->bindValue(':key', $configuration->getKey());
             * $stmt->bindValue(':value', $configuration->getValue());
             * $stmt->execute();
             */

        }

        /*
         * if PDO
         * $success = $pdoObject->commit();
         * } catch(\PDOException $e) {
         *  $pdoObject->rollBack();
         *  error_log($e);
         *  -- optional email to developer here --
         *   throw new UnableToCreateConfigurationException("Cannot insert configuration.");
         * }
         *
         * OR
         *
         * $entityManager->flush();
         * $entityManager->getConnection()->commit();
         * } catch( \Exception $e) {
         *  $entityManager->getConnection()->rollBack();
         *  error_log($e);
         *  -- optional email to developer here --
         *   throw new UnableToCreateConfigurationException("Cannot insert configuration.");
         * }
         *
         */

    }
}