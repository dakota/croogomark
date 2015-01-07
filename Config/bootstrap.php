<?php
Configure::write('Croogodown.node_fields', array(
    'excerpt',
    'body',
));

Croogo::hookHelper('Nodes', 'Croogodown.Markdown');