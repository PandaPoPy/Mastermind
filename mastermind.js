$(function(){

    var initialisation = false;
    var ligne_active = 1;
    var colonne_active = 1;
    var proposition = [];

    function afficher_notif(classe, message) {

        // on appelle PHP pour obtenir la réponse
        $.get('ajax.php', {'action': 'reponse'}, function(data) {
            if(!('erreur' in data)) {
                var solution_ligne = $('[data-line="solution"]');
                var solution_col = 1;
                for(var i in data['solution']) {
                    var pion = $('<div/>', {'class': 'mm-pawn', 'data-color': data['solution'][i]});
                    $('[data-pawn="'+solution_col+'"]', solution_ligne).append(pion);
                    solution_col++;
                }
            } else {
                alert(data['erreur']);
            }
        });

        initialisation = false;
        var win = $('<div/>', {'class': 'popup '+classe});
        var win_bg = $('<div/>', {'class': 'win_background'});
        win.html(message+'<br /><a href="index.php">Rejouer</a>');
        $('body').append(win_bg);
        $('body').append(win);
    }

    // démarrage de la partie : on initialise le jeu
    $.get('ajax.php', {'action': 'initialisation'}, function(data) {
        if(!('erreur' in data)) {
            initialisation = true;
        } else {
            alert(data['erreur']);
        }
    });

    $('#mm-pawn-board .mm-pawn').click(function(ev) {
        if(initialisation) {
            if(colonne_active <= 4) {
                var couleur = $(this).data('color');
                proposition.push(couleur);
                var cible = $('[data-line="'+ligne_active+'"] [data-pawn="'+colonne_active+'"]');
                var pion = $('<div/>', {'class': 'mm-pawn', 'data-color': couleur});
                cible.append(pion);
                colonne_active++;
                if(colonne_active > 4) {
                    // affichage de la marque de validation
                    var cible_validation = $('.mm-score-bullet', $('[data-line="'+ligne_active+'"]'));
                    var validation = $('<div/>', {'class': 'mm-check-button', 'title': 'Vérifier cette ligne'});
                    validation.text('✓');
                    cible_validation.append(validation);
                }
            }
        }
    });

    $('#board').on('click', '.mm-check-button', function(ev){
        if(initialisation) {
            $.get('ajax.php', {'action': 'validation', 'proposition': proposition}, function(data) {
                if(!('erreur' in data)) {
                    $('[data-line="'+ligne_active+'"], [data-line="'+ligne_active+'"] .mm-pawn').addClass('played');
                    $('[data-line="'+ligne_active+'"] .mm-check-button').remove();
                    for(var i = 0; i < data['rouges']; i++) {
                        var pion_resultat = $('<div/>', {'class': 'mm-point mm-point-red'});
                        $('[data-line="'+ligne_active+'"] .mm-score-bullet').append(pion_resultat);
                    }

                    for(var i = 0; i < data['blancs']; i++) {
                        var pion_resultat = $('<div/>', {'class': 'mm-point mm-point-white'});
                        $('[data-line="'+ligne_active+'"] .mm-score-bullet').append(pion_resultat);
                    }
                    if(data['rouges'] == 4) {
                        // on a gagné
                        afficher_notif('win', 'Vous avez gagné ! Félicitations !');
                    } else if(ligne_active == 10) {
                        // on a perdu
                        afficher_notif('lose', 'Vous avez perdu ☹');
                    } else {
                        ligne_active++;
                        colonne_active = 1;
                        proposition = [];
                    }
                } else {
                    alert(data['erreur']);
                }
            });
        }
    });

    $('.mm-board').on('click', '.mm-pawn:not(.played)', function(ev){
        // faire apparaître le voile
        var veil = $('<div />', {'class': 'veil'});
        $('body').append(veil);

        // on crée un pion par-dessus le voile
        var pion = $(this).clone();
        var pion_initial = $(this);
        pion.removeClass('mm-pawn').addClass('mm-pawn-clone');
        /*pion.css({'top': $(this).offset().top + 'px',
                  'left': $(this).offset().left + 'px'});*/
        pion.offset($(this).offset());
        $('body').append(pion);

        // on crée le menu edit-mode

        // gestion de la flèche
        var orientation = $(this).offset().top < 100 ? 'bottom' : 'top';
        var edit_mode_arrow = $('<div />', {'class': 'edit-mode-arrow '+orientation});
        var offset = {'top': 0, 'left': 0};
        if(orientation == 'top') {
            offset['top'] = $(this).offset().top - edit_mode_arrow.height();
        } else {
            offset['top'] = $(this).offset().top + $(this).height();
        }

        offset['left'] = ($(this).offset().left + ($(this).width() / 2)) - (edit_mode_arrow.width() / 2);
        edit_mode_arrow.offset(offset);
        $('body').append(edit_mode_arrow);

        // gestion du menu
        var edit_mode = $('<div />', {'class': 'edit-mode'});
        var offset = {'top': 0, 'left': $(this).parents('.mm-board').offset().left+1};
        if(orientation == 'top') {
            offset['top'] = edit_mode_arrow.position().top - edit_mode.height();
        } else {
            offset['top'] = edit_mode_arrow.position().top + edit_mode_arrow.height();
        }

        var pions = $('#mm-pawn-board .mm-pawn').clone();
        console.log(pions);
        pions.hover(function(ev) {
            var nouvelle_couleur = $(this).data('color');
            pion.data('oldcolor', pion.data('color'));
            // pion.data('color', nouvelle_couleur); // ne fonctionne pas lorsqu’on veut que css prenne compte
            pion.attr('data-color', nouvelle_couleur);
        }, function(ev) {
            // pion.data('color', pion.data('oldcolor'));
            pion.attr('data-color', pion.data('oldcolor'));
            pion.removeData('oldcolor');
        });
        pions.click(function(ev) {
            var nouvelle_couleur = $(this).data('color');
            pion_initial.attr('data-color', nouvelle_couleur);
            proposition[pion_initial.parent().data('pawn') - 1] = nouvelle_couleur;
            console.log(pion_initial.data());
            $('.veil').remove();
            $('.mm-pawn-clone').remove();
            $('.edit-mode-arrow').remove()
            $('.edit-mode').remove()
        });
        edit_mode.append(pions);

        edit_mode.offset(offset);
        $('body').append(edit_mode);

    });

    $('body').on('click', '.veil', function(ev) {
        $(this).remove();
        $('.mm-pawn-clone').remove();
        $('.edit-mode-arrow').remove()
        $('.edit-mode').remove()
    });


});
