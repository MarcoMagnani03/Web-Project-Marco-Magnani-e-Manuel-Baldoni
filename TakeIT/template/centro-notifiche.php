
<header>
    <h2>Centro notifiche</h2>
    <?php if(count($templateParams["notifiche"]) == 0): ?>
    <article>
        <p>Non ci sono notifiche</p>
    </article>
    <?php else:
        $notifiche = $templateParams["notifiche"];
        ?>
        <button id="btnTutte" type="button" name="tutte" aria-label="Mostra tutte le notifiche">Tutte</button>
        <button id="btnLette" type="button" name="lette" aria-label="Mostra notifiche lette">Lette</button>
        <button id="btnNonLette" type="button" name="non-lette" aria-label="Mostra notifiche non lette">Non Lette</button>
</header>
<?php foreach($notifiche as $notifica): ?>
    <article>
        <header>
            <h3><?php echo $notifica["titolo"] ?></h3>
            <button id="bottoneEliminazione" type="button" aria-label="Elimina questa notifica" onclick="eliminaNotifica(<?php echo $notifica['codice']; ?>)">
                <em aria-hidden="true" class="fa-solid fa-trash"></em>
                <span class="fa-sr-only">Elimina la notifica</span>
		    </button>
        </header>
        <p><?php echo $notifica["contenuto"] ?></p>
        <footer>
        <time datetime="<?php echo date('c', strtotime($notifica['dataOraCreazione'])); ?>">
            <?php echo date('d/m/Y - H:i', strtotime($notifica['dataOraCreazione'])); ?>
        </time>
    </footer>
    </article>
<?php endforeach; ?>
<?php endif;?>
