<?php
use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1700469271.
 * Generated on 2023-11-20 08:34:31  */
class PropelMigration_1700469271{
    /**
     * @var string
     */
    public $comment = '';

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
        $con = $manager->getAdapterConnection("connection_1");

        $stmt = $con->prepare("INSERT INTO `user` (`USERNAME`, `PASSWORD`, `ROLES`) VALUES (:username, :password, :roles)");
        $stmt->bindValue(':username', 'admin');
        $stmt->bindValue(':password', '$2y$13$5OTYMjJHwyNNlNkgHVGzueYODJVUIUpHxXxGRkJb2pdGwRO7SvGua'); // admin
        $stmt->bindValue(':roles', '| ROLE_SUPER_ADMIN |');

        $stmt->execute();
    }

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    /**
     * @param \Propel\Generator\Manager\MigrationManager $manager
     *
     * @return null|false|void
     */
    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL(): array
    {
        $connection_connection_1 = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `user`
(
    `PK_` INTEGER NOT NULL AUTO_INCREMENT,
    `USERNAME` VARCHAR(100) NOT NULL,
    `PASSWORD` TEXT NOT NULL,
    `ROLES` TEXT,
    PRIMARY KEY (`PK_`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return [
            'connection_1' => $connection_connection_1,
        ];
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL(): array
    {
        $connection_connection_1 = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `user`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return [
            'connection_1' => $connection_connection_1,
        ];
    }

}
