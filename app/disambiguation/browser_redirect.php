<!DOCTYPE html>
<html lang="en">

<?php

/** @var string $var */
/** @var string $title */
/** @var string $instructions */
/** @var string $target */
/** @var string $request */

$url = str_replace(":$var", $_GET[$var][0], "https://portals.veracross.com/groton{$request}");
[$caption] = $_GET['caption'] ?: '';
$style = "";
preg_match("/\((.+ )?(RD|OR|YL|GR|LB|DB|PR|W|X|Y|Z)( .+)?\)$/", $caption, $matches);
[,, $block] = $matches;
if (!empty($block)) {
    $style = strtolower("background: var(--$block); color: var(--text-on-$block); border-color: var(--text-on-$block);");
}

?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Groton School: <?= $title ?></title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script type="text/javascript">
        /* global document, self, top */
        try {
            top.location.replace('<?= $url ?>');
        } catch (_) {
            function addStylesheet(href) {
                const linkElt = document.createElement('link');
                linkElt.rel = 'stylesheet';
                linkElt.href = href;
                document.head.appendChild(linkElt);
            }

            addStylesheet('https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css')
            addStylesheet('https://cdn.jsdelivr.net/npm/@groton/colors@0.2.0/vars.css')

            const modalElt = document.createElement('div');
            modalElt.id = 'modal'
            modalElt.classList.add('modal', 'fade');
            modalElt.tabIndex = -1;
            modalElt.dataset.bsKeyboard = false;
            modalElt.dataset.bsBackdrop = 'static';
            modalElt.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $title ?></h5>
                    </div>
                    <div class="modal-body">
                        <?= empty($instructions) ? '' : "<p>$instructions</p>" ?>
                    </div>
                </div>
            </div>`;
            document.body.appendChild(modalElt);
            const modalBodyElt = modalElt.querySelector('.modal-body');

            const buttonElt = document.createElement('div');
            buttonElt.innerHTML = `<a
                class="btn btn-primary"
                href="<?= $url ?>"
                target="<?= $target ?>"
                <?= empty($style) ? '' : "style=\"$style\"" ?>
            ><?= $caption ?></a>`;
            modalBodyElt.appendChild(buttonElt);

            const instructionsElt = document.createElement('div');
            instructionsElt.classList.add('pt-3');
            instructionsElt.innerHTML =
                "<p>Don't want to have to click here again? Enable redirects by " +
                'clicking on the icon in the location bar above.<br/>' +
                `<img src="https://groton-school.github.io/redirect/assets/redirects.png" height="200" /></p>`;
            modalBodyElt.appendChild(instructionsElt);

            bootstrap.Modal.getOrCreateInstance('#modal').show()
        }
    </script>
</body>

</html>