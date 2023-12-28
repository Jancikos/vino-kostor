<?php
use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1703789124.
 * Generated on 2023-12-28 18:45:24  */
class PropelMigration_1703789124{
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


CREATE INDEX `fi_order_customer` ON `myorder` (`CUSTOMER_PK_`);

CREATE INDEX `fi_order_user` ON `myorder` (`USER_PK_`);

ALTER TABLE `myorder` ADD CONSTRAINT `fk_order_customer`
    FOREIGN KEY (`CUSTOMER_PK_`)
    REFERENCES `customer` (`PK_`);

ALTER TABLE `myorder` ADD CONSTRAINT `fk_order_user`
    FOREIGN KEY (`USER_PK_`)
    REFERENCES `user` (`PK_`);


CREATE INDEX `fi_order_item_order` ON `myorder_item` (`ORDER_PK_`);

CREATE INDEX `fi_order_item_product` ON `myorder_item` (`PRODUCT_PK_`);

ALTER TABLE `myorder_item` ADD CONSTRAINT `fk_order_item_order`
    FOREIGN KEY (`ORDER_PK_`)
    REFERENCES `myorder` (`PK_`);

ALTER TABLE `myorder_item` ADD CONSTRAINT `fk_order_item_product`
    FOREIGN KEY (`PRODUCT_PK_`)
    REFERENCES `product` (`PK_`);

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

ALTER TABLE `myorder` DROP FOREIGN KEY `fk_order_customer`;

ALTER TABLE `myorder` DROP FOREIGN KEY `fk_order_user`;

DROP INDEX `fi_order_customer` ON `myorder`;

DROP INDEX `fi_order_user` ON `myorder`;


ALTER TABLE `myorder_item` DROP FOREIGN KEY `fk_order_item_order`;

ALTER TABLE `myorder_item` DROP FOREIGN KEY `fk_order_item_product`;

DROP INDEX `fi_order_item_order` ON `myorder_item`;

DROP INDEX `fi_order_item_product` ON `myorder_item`;


# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return [
            'connection_1' => $connection_connection_1,
        ];
    }

}
