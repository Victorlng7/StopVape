# Calculateur_CE

This template should help get you started developing with Vue 3 in Vite.

## Recommended IDE Setup

[VS Code](https://code.visualstudio.com/) + [Vue (Official)](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur).

## Recommended Browser Setup

- Chromium-based browsers (Chrome, Edge, Brave, etc.):
  - [Vue.js devtools](https://chromewebstore.google.com/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd)
  - [Turn on Custom Object Formatter in Chrome DevTools](http://bit.ly/object-formatters)
- Firefox:
  - [Vue.js devtools](https://addons.mozilla.org/en-US/firefox/addon/vue-js-devtools/)
  - [Turn on Custom Object Formatter in Firefox DevTools](https://fxdx.dev/firefox-devtools-custom-object-formatters/)

## Type Support for `.vue` Imports in TS

TypeScript cannot handle type information for `.vue` imports by default, so we replace the `tsc` CLI with `vue-tsc` for type checking. In editors, we need [Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar) to make the TypeScript language service aware of `.vue` types.

## Customize configuration

See [Vite Configuration Reference](https://vite.dev/config/).

## Project Setup

```sh
bun install
```

### Compile and Hot-Reload for Development

```sh
bun dev
```

### Type-Check, Compile and Minify for Production

```sh
bun run build
```

## Configuration de l'API et des sessions

L'API utilise une session PHP (cookie `HttpOnly` et `SameSite=Strict`) pour
identifier l'utilisateur. Les actions de lecture et d'écriture prennent
l'utilisateur de cette session : ne pas envoyer d'identifiant utilisateur
depuis le navigateur pour autoriser l'accès aux données.

En développement, l'origine `http://localhost:5173` est autorisée par défaut.
Pour une autre origine ou un déploiement, configurer `APP_ORIGINS` dans
`api/.env` avec une liste séparée par des virgules, puis configurer
`VITE_API_URL` dans l'environnement de build Vite. En production, servir
l'application et l'API en HTTPS et n'autoriser que les origines de confiance.
