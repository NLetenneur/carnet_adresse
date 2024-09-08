namespace App\Service;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

class ContactImportService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function importFromCsv(string $csvFilePath, $user)
    {
        $file = fopen($csvFilePath, 'r');

        while (($data = fgetcsv($file)) !== FALSE) {
            $contact = new Contact();
            $contact->setNom($data[0]);
            $contact->setPrenom($data[1]);
            $contact->setEmail($data[2]);
            $contact->setTelephone($data[3]);
            $contact->setUser($user);

            $this->entityManager->persist($contact);
        }

        fclose($file);
        $this->entityManager->flush();
    }
}
