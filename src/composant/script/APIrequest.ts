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

        if (!reponse.ok) {
            throw new Error(`Erreur HTTP: ${reponse.status}`);
        }

        return await reponse.json();
    } catch (erreur) {
        console.error("Erreur de communication avec l'API :", erreur);
        return { erreur: "Impossible de joindre le serveur" };
    }
}
