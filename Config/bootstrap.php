<?php
Configure::write('Croogomark.node_fields', array(
    'excerpt',
    'body',
));

Croogo::hookHelper('Nodes', 'Croogomark.Markdown');