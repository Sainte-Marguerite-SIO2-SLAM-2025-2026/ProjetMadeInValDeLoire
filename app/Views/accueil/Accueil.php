<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
</head>
<body>
<h1>Menu Principal</h1>
<nav>
    <?= anchor(base_url().'/Salle1', '<button>Salle 1</button>'); ?>
    <?= anchor(base_url().'/Salle2', '<button>Salle 2</button>'); ?>
    <?= anchor(base_url().'/Salle3', '<button>Salle 3</button>'); ?>
    <?= anchor(base_url().'/Salle4', '<button>Salle 4</button>'); ?>
    <?= anchor(base_url().'/Salle5', '<button>Salle 5</button>'); ?>
    <?= anchor(base_url().'/Salle6', '<button>Salle 6</button>'); ?>
</nav>
