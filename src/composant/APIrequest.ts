export interface AuthenticatedUser {
    id: number;
    email: string;
    nom: string;
    prenom: string;
}

export interface ApiResponse {
    utilisateur?: AuthenticatedUser | null;
    resultat?: unknown;
    success?: boolean;
    erreur?: string;
}

const apiUrl =
    import.meta.env.VITE_API_URL ??
    (import.meta.env.DEV
        ? "http://localhost:8000/api/index.php"
        : "/api/index.php");

export async function requeteAPI(
    action: string,
    donneesExtras: Record<string, unknown> = {},
): Promise<ApiResponse> {
    const reponse = await fetch(apiUrl, {
        method: "POST",
        credentials: "include",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action, ...donneesExtras }),
    });

    const data: ApiResponse = await reponse.json();
    if (!reponse.ok && !data.erreur) {
        data.erreur = `Erreur serveur (${reponse.status})`;
    }

    return data;
}
