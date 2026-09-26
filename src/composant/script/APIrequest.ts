export async function requeteAPI(
    action: string,
    donneesExtras: Record<string, any> = {},
) {
    try {
        // On fusionne l'action avec les autres données à envoyer
        const payload = { action: action, ...donneesExtras };

        const reponse = await fetch("http://localhost:8000/api/index.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload),
        });

        const data = await reponse.json();

        if (!reponse.ok) {
            console.error("Détail du crash PHP :", data.erreur);
            throw new Error(`Serveur : ${data.erreur || reponse.status}`);
        }

        return data;

        // return await reponse.json();
    } catch (erreur) {
        console.error("Erreur de communication avec l'API :", erreur);
        return { erreur: "Impossible de joindre le serveur" };
    }
}
