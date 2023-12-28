<?php
use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1703746857.
 * Generated on 2023-12-28 07:00:57  */
class PropelMigration_1703746857{
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

CREATE TABLE `myorder`
(
    `PK_` INTEGER NOT NULL AUTO_INCREMENT,
    `CUSTOMER_PK_` INTEGER NOT NULL,
    `USER_PK_` INTEGER NOT NULL COMMENT 'user, ktory spravuje tuto objednavku',
    `STATUS` INTEGER NOT NULL,
    `CREATED` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `PACKED` TIMESTAMP NULL,
    `SHIPPED` TIMESTAMP NULL,
    `PAIED` TIMESTAMP NULL,
    `REAL_PRICE` FLOAT COMMENT 'cena, ktoru zakaznik naozaj zakaznik zaplatil',
    `NOTE` VARCHAR(500),
    PRIMARY KEY (`PK_`)
) ENGINE=InnoDB;

CREATE TABLE `myorder_item`
(
    `PK_` INTEGER NOT NULL AUTO_INCREMENT,
    `ORDER_PK_` INTEGER NOT NULL,
    `PRODUCT_PK_` INTEGER NOT NULL,
    `QUANTITY` INTEGER NOT NULL,
    `PRICE` FLOAT NOT NULL COMMENT 'cena, ktoru stal kus daneho produktu v case jeho pridania do objednavky',
    `NOTE` VARCHAR(500),
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

DROP TABLE IF EXISTS `myorder`;

DROP TABLE IF EXISTS `myorder_item`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return [
            'connection_1' => $connection_connection_1,
        ];
    }

}
