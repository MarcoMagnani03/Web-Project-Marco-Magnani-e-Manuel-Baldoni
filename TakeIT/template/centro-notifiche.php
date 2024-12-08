<header>
    <h2>Centro notifiche</h2>
    <?php if(count($templateParams["notifiche"]) == 0): ?>
        <article>
            <p>Non ci sono notifiche</p>
        </article>
    <?php else:
        $notifiche = array_slice($templateParams["notifiche"], 0, 10); 
        ?>
        <ul>
            <li>
                <button id="btnTutte" type="button" name="tutte" aria-label="Mostra tutte le notifiche" onclick="mostraTutte()">Tutte</button>
            </li>
            <li>
                <button id="btnLette" type="button" name="lette" aria-label="Mostra notifiche lette" onclick="mostraLette()">Lette</button>        
            </li>
            <li>
                <button id="btnNonLette" type="button" name="non-lette" aria-label="Mostra notifiche non lette" onclick="mostraNonLette()">Non Lette</button>
            </li>
        </ul>
</header>
<section>
    <h2 id="notifiche" class="sr-only">Notifiche</h2> 
    <?php foreach($notifiche as $notifica): 
        $contenuto = $notifica["contenuto"];
        $isLong = strlen($contenuto) > 100; 
    ?>
        <article data-codice-notifica="<?php echo $notifica['codice'] ?>" data-notifica-letta="<?php echo $notifica['letta'] ? 'true' : 'false'; ?>" onclick="segnaComeLetta(this)">
            <header>
                <h3><?php echo $notifica["titolo"] ?></h3>
                <button type="button" aria-label="Elimina questa notifica" onclick="eliminaNotifica(<?php echo $notifica['codice']; ?>)">
                    <span aria-hidden="true" class="fa-solid fa-trash"></span>
                    <span class="fa-sr-only">Elimina la notifica</span>
                </button>
            </header>
            <p>
                <?php echo substr($contenuto, 0, 100); ?>
                <?php if($isLong): ?>
                    <span style="display: none;"><?php echo substr($contenuto, 100); ?></span>
                    <button type="button" onclick="toggleContent(event, this)">Leggi tutto</button>
                <?php endif; ?>
            </p>
            <footer>
                <time datetime="<?php echo date('c', strtotime($notifica['dataOraCreazione'])); ?>">
                    <?php echo date('d/m/Y - H:i', strtotime($notifica['dataOraCreazione'])); ?>
                </time>
            </footer>
        </article>
    <?php endforeach; ?>
</section>
<button id="btnMostraAltre" type="button" onclick="mostraAltreNotifiche()" aria-label="Mostra altre notifiche">Mostra altre notifiche</button>
<?php endif; ?>
