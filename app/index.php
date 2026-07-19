<?php

$request = $_SERVER['REQUEST_URI'];
$url = parse_url($request);
preg_match('@:([^/]+)@', $url['path'], $matches);
[, $var] = $matches;
if (empty($var)) {
    header("Location: https://portals.veracross.com/groton{$_SERVER['REQUEST_URI']}");
} else {
    $title = $_GET['title'] ?: 'Disambiguation';
    $instructions = $_GET['instructions'] ?: 'Choose one';
    $target = $_GET['target'] ?: '_top';

    parse_str($url['query'],  $query);
    unset($query['title']);
    unset($query['instructions']);
    unset($query['target']);
    unset($query[$var]);
    unset($query['caption']);
    $url['query'] = http_build_query($query);
    $request = $url['path'] . (empty($query) ? '' : '?' . $url['query']) . (empty($url['fragment']) ? '' : '#' . $url['fragment']);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Groton School: <?= $title ?></title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@groton/colors@0.2.0/vars.css" />
    </head>

    <body>
        <div id="modal" class="modal fade" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $title ?></h5>
                    </div>
                    <div class="modal-body">
                        <?= empty($instructions) ? '' : "<p>$instructions</p>" ?>
                        <?php
                        foreach ($_GET[$var] as $i => $value) {
                            $style = "";
                            $text = $_GET['caption'][$i] ?: $value;
                            preg_match("/\((.+ )?(RD|OR|YL|GR|LB|DB|PR)( .+)?\)$/", $text, $matches);
                            if (!empty($matches[2])) {
                                $color = strtolower($matches[2]);
                                $style = "style=\"background: var(--$color); color: var(--text-on-$color);\"";
                            }
                        ?>
                            <div>
                                <a
                                    href="<?= str_replace(
                                                ":$var",
                                                $_GET[$var][$i],
                                                "https://portals.veracross.com/groton{$request}"
                                            ) ?>"
                                    class="btn btn-secondary m-3"
                                    <?= $style ?>
                                    target="<?= $target ?>">
                                    <?= $text ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <script>
            bootstrap.Modal.getOrCreateInstance('#modal').show()
        </script>
    </body>

    </html>
<?php }
