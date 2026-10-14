export function IsMail(mail: string): boolean {
    if (mail.includes("@")) {
        const splitMail = mail.split("@");
        if (splitMail[1] && splitMail[1].includes(".")) {
            console.log("mail good");
            return true;
        } else return false;
    } else return false;
}
