<script setup lang="ts">
import "./assets/styleDeco.css";
import App from "@/App.vue";
</script>

```vue
<template>
    <div class="page">
        <!-- En-tête -->
        <header class="header">
            <div class="header__container">
                <div class="header__brand">
                    <span class="header__title">StopSmoke</span>
                    <img class="header__logo" src="" alt="Logo StopSmoke" />
                </div>

                <nav class="header__nav">
                    <a class="header__link header__link--active" href="#">
                        Accueil
                    </a>
                    <a class="header__link" href="#"> À propos </a>
                    <a class="header__link" href="#"> Se connecter </a>
                </nav>
            </div>
        </header>

        <!-- Présentation -->
        <main class="main">
            <section class="hero">
                <div class="hero__content">
                    <span class="hero__badge"
                        >Un accompagnement simple et gratuit</span
                    >

                    <h1 class="hero__title">
                        Vous souhaitez réduire ou arrêter votre consommation de
                        cigarette électronique ?
                    </h1>

                    <p class="hero__description">
                        Découvrez un outil simple pour suivre votre
                        consommation, mieux comprendre vos habitudes et mesurer
                        vos progrès au fil du temps.
                    </p>

                    <div class="hero__actions">
                        <a class="button button--primary" href="#">
                            Commencer gratuitement
                        </a>
                        <a class="button button--secondary" href="#">
                            En savoir plus
                        </a>
                    </div>
                </div>
            </section>

            <!-- Fonctionnalités -->
            <section class="features section">
                <div class="section__header">
                    <span class="section__badge">Fonctionnalités</span>

                    <h2 class="section__title">
                        Une approche simple pour suivre vos progrès
                    </h2>

                    <p class="section__description">
                        StopSmoke vous accompagne au quotidien grâce à des
                        outils simples qui vous permettent de mieux visualiser
                        votre consommation.
                    </p>
                </div>

                <div class="features__grid">
                    <article class="feature-card">
                        <div class="feature-card__icon"> 🧪 </div>

                        <h3 class="feature-card__title">
                            Créez vos propres e-liquides
                        </h3>

                        <p class="feature-card__text">
                            Gardez une trace de vos recettes et des différents
                            composants utilisés dans vos e-liquides afin de
                            mieux contrôler votre consommation.
                        </p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-card__icon"> 📊 </div>

                        <h3 class="feature-card__title">
                            Suivez votre consommation
                        </h3>

                        <p class="feature-card__text">
                            Renseignez simplement votre consommation quotidienne
                            afin de visualiser son évolution au fil des jours et
                            des semaines.
                        </p>
                    </article>

                    <article class="feature-card">
                        <div class="feature-card__icon"> 💰 </div>

                        <h3 class="feature-card__title">
                            Suivez vos dépenses
                        </h3>

                        <p class="feature-card__text">
                            Visualisez l'argent consacré à votre consommation et
                            mesurez concrètement les économies réalisées au
                            cours de votre démarche.
                        </p>
                    </article>
                </div>
            </section>

            <!-- Fonctionnement -->
            <section class="how-it-works section">
                <div class="how-it-works__content">
                    <div class="how-it-works__text">
                        <span class="section__badge"
                            >Comment ça fonctionne ?</span
                        >

                        <h2 class="section__title">
                            Quelques secondes par jour pour mieux comprendre vos
                            habitudes
                        </h2>

                        <p class="section__description">
                            Chaque jour, renseignez simplement quelques
                            informations concernant votre consommation.
                            L'objectif est de rendre le suivi aussi rapide et
                            simple que possible.
                        </p>

                        <p class="section__description">
                            À partir de ces données, StopSmoke peut générer des
                            statistiques et des graphiques permettant de suivre
                            votre évolution, votre consommation de nicotine et
                            vos dépenses.
                        </p>
                    </div>

                    <div class="how-it-works__steps">
                        <div class="step">
                            <span class="step__number">01</span>

                            <div class="step__content">
                                <h3 class="step__title">
                                    Renseignez votre consommation
                                </h3>

                                <p class="step__text">
                                    Quelques informations suffisent pour
                                    enregistrer votre journée.
                                </p>
                            </div>
                        </div>

                        <div class="step">
                            <span class="step__number">02</span>

                            <div class="step__content">
                                <h3 class="step__title">
                                    Consultez vos statistiques
                                </h3>

                                <p class="step__text">
                                    Retrouvez vos données sous forme de
                                    statistiques et de graphiques.
                                </p>
                            </div>
                        </div>

                        <div class="step">
                            <span class="step__number">03</span>

                            <div class="step__content">
                                <h3 class="step__title">
                                    Visualisez votre évolution
                                </h3>

                                <p class="step__text">
                                    Observez vos progrès et l'évolution de vos
                                    habitudes au fil du temps.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Avantages -->
            <section class="benefits section">
                <div class="section__header">
                    <span class="section__badge">Pourquoi StopSmoke ?</span>

                    <h2 class="section__title">
                        Un suivi pensé pour rester simple
                    </h2>
                </div>

                <div class="benefits__grid">
                    <article class="benefit-card">
                        <div class="benefit-card__icon"> ⏱️ </div>

                        <h3 class="benefit-card__title">
                            Moins d'une minute par jour
                        </h3>

                        <p class="benefit-card__text">
                            Le suivi quotidien est conçu pour être rapide. Pas
                            besoin de réaliser de calculs complexes : renseignez
                            simplement vos données.
                        </p>
                    </article>

                    <article class="benefit-card">
                        <div class="benefit-card__icon"> 📈 </div>

                        <h3 class="benefit-card__title">
                            Des données faciles à comprendre
                        </h3>

                        <p class="benefit-card__text">
                            Vos informations sont transformées en statistiques
                            et en graphiques afin de rendre votre évolution plus
                            facile à visualiser.
                        </p>
                    </article>

                    <article class="benefit-card">
                        <div class="benefit-card__icon"> 💶 </div>

                        <h3 class="benefit-card__title">
                            Visualisez vos économies
                        </h3>

                        <p class="benefit-card__text">
                            Suivez l'évolution de vos dépenses et visualisez
                            concrètement les économies réalisées au cours de
                            votre démarche.
                        </p>
                    </article>
                </div>
            </section>

            <!-- Gratuité -->
            <section class="pricing section">
                <div class="pricing__card">
                    <div class="pricing__content">
                        <span class="section__badge">Tarification</span>

                        <h2 class="pricing__title">
                            Un outil entièrement gratuit
                        </h2>

                        <p class="pricing__text">
                            StopSmoke est entièrement gratuit. Notre objectif
                            est de proposer un outil accessible à toutes les
                            personnes qui souhaitent mieux comprendre et réduire
                            leur consommation.
                        </p>
                    </div>

                    <div class="pricing__price">
                        <span class="pricing__amount">0 €</span>
                        <span class="pricing__label">pour toujours</span>
                    </div>
                </div>
            </section>

            <!-- Call to action -->
            <section class="get-started">
                <div class="get-started__content">
                    <span class="get-started__badge"> Prêt à commencer ? </span>

                    <h2 class="get-started__title">
                        Commencez à suivre votre consommation dès aujourd'hui.
                    </h2>

                    <p class="get-started__description">
                        Créez votre compte gratuitement et commencez à utiliser
                        StopSmoke en quelques instants.
                    </p>

                    <div class="get-started__actions">
                        <button class="button button--light" @click="">
                            Se connecter
                        </button>

                        <button class="button button--outline-light" @click="">
                            Créer un compte
                        </button>
                    </div>

                    <p class="get-started__note">
                        Aucun engagement. Vous pouvez supprimer votre compte
                        quand vous le souhaitez.
                    </p>
                </div>
            </section>
        </main>
    </div>
</template>
