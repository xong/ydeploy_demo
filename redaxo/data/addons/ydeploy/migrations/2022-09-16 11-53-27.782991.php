<?php

$sql = rex_sql::factory();
$sql->setQuery('SET FOREIGN_KEY_CHECKS = 0');

try {
    rex_sql_table::get('rex_teilnehmer')
        ->ensureColumn(new rex_sql_column('id', 'int(10) unsigned', false, null, 'auto_increment'))
        ->ensureColumn(new rex_sql_column('name', 'text', false, null, null))
        ->ensureColumn(new rex_sql_column('email', 'text', false, null, null))
        ->setPrimaryKey(['id'])
        ->ensure();

    rex_sql_table::get('rex_yform_field')
        ->ensureColumn(new rex_sql_column('no_db', 'text', false, null, null), 'choice_attributes')
        ->alter();

    $sql->setQuery(<<<'SQL'
        INSERT INTO `rex_yform_field` (`id`, `table_name`, `prio`, `type_id`, `type_name`, `db_type`, `list_hidden`, `search`, `name`, `label`, `not_required`, `multiple`, `expanded`, `choices`, `choice_attributes`, `no_db`)
        VALUES
            (1, 'rex_teilnehmer', 1, 'value', 'text', 'text', 0, 1, 'name', 'Name', '', '', '', '', '', 0),
            (2, 'rex_teilnehmer', 2, 'value', 'text', 'text', 0, 1, 'email', 'E-Mail-Adresse', '', '', '', '', '', 0)
        ON DUPLICATE KEY UPDATE `table_name` = VALUES(`table_name`), `prio` = VALUES(`prio`), `type_id` = VALUES(`type_id`), `type_name` = VALUES(`type_name`), `db_type` = VALUES(`db_type`), `list_hidden` = VALUES(`list_hidden`), `search` = VALUES(`search`), `name` = VALUES(`name`), `label` = VALUES(`label`), `not_required` = VALUES(`not_required`), `multiple` = VALUES(`multiple`), `expanded` = VALUES(`expanded`), `choices` = VALUES(`choices`), `choice_attributes` = VALUES(`choice_attributes`), `no_db` = VALUES(`no_db`)
        SQL);

    $sql->setQuery(<<<'SQL'
        INSERT INTO `rex_yform_table` (`id`, `status`, `table_name`, `name`, `description`, `list_amount`, `list_sortfield`, `list_sortorder`, `prio`, `search`, `hidden`, `export`, `import`, `mass_deletion`, `mass_edit`, `schema_overwrite`, `history`)
        VALUES
            (1, 1, 'rex_teilnehmer', 'Teilnehmer', '', 50, 'id', 'ASC', 1, 0, 0, 0, 0, 0, 0, 1, 0)
        ON DUPLICATE KEY UPDATE `status` = VALUES(`status`), `table_name` = VALUES(`table_name`), `name` = VALUES(`name`), `description` = VALUES(`description`), `list_amount` = VALUES(`list_amount`), `list_sortfield` = VALUES(`list_sortfield`), `list_sortorder` = VALUES(`list_sortorder`), `prio` = VALUES(`prio`), `search` = VALUES(`search`), `hidden` = VALUES(`hidden`), `export` = VALUES(`export`), `import` = VALUES(`import`), `mass_deletion` = VALUES(`mass_deletion`), `mass_edit` = VALUES(`mass_edit`), `schema_overwrite` = VALUES(`schema_overwrite`), `history` = VALUES(`history`)
        SQL);
} finally {
    $sql = rex_sql::factory();
    $sql->setQuery('SET FOREIGN_KEY_CHECKS = 1');
}
