<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de PDF</title>
    <link rel="stylesheet" type="text/css" href="viewerjs/viewer.css">
    <script type="text/javascript" src="viewerjs/viewer.js"></script>
</head>
<body>
    <div id="viewer" style="height: 600px;"></div>

    <script>
        var viewer = new Viewer(document.getElementById('viewer'), {
            url: 'preview.php?file=<?php echo urlencode('/tccs'); ?>',
            navbar: false,
            toolbar: {
                zoomIn: 4,
                zoomOut: 4,
                oneToOne: 4,
                reset: 4,
                prev: 4,
                play: {
                    show: false,
                    size: 'large',
                },
                next: 4,
                rotateLeft: 4,
                rotateRight: 4,
                flipHorizontal: 4,
                flipVertical: 4,
            },
        });
    </script>
</body>
</html>
