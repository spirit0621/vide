<?php
//CRUD
class Annonce 
{
    private $bdd;
	function __construct($bdd)
	{
		$this->bdd = $bdd;
	}
	public function addAnn($titre, $adresse, $typeCon, $description,$salaire,$duree,$dateAnn,$idManager)
	{
		$req = $this->bdd->prepare("INSERT INTO Annonce (Titre, Adresse, TypeCon,description,Salaire,Duree,DateAnn,IdManager) VALUES (:titre , :adresse, :typeCon, :description,:salaire,:duree,:dateAnn,:idManager)");
		$req->bindParam(':titre', $titre);
		$req->bindParam(':adresse', $adresse);
		$req->bindParam(':typeCon', $typeCon);
		$req->bindParam(':description',$description);
        $req->bindParam(':salaire',$salaire);
        $req->bindParam(':duree',$duree);
        $req->bindParam(':dateAnn',$dateAnn);
        $req->bindParam(':idManager',$idManager);
		return $req->execute();
	}
	public function allAnn()
	{
		$req = $this->bdd->prepare("SELECT * FROM Annonce");
		$req->execute();
		return $req->fetchAll();
	}
	function deleteAnn($idA)
    {
        try {
            $this->bdd->beginTransaction();

            // Supprimer les candidatures liées à l'annonce
            $req = $this->bdd->prepare("DELETE FROM Candidature WHERE idAnnonce = ?");
            $req->execute([$idA]);

            // Supprimer l'annonce
            $req = $this->bdd->prepare("DELETE FROM Annonce WHERE idAnnonce = ?");
            $req->execute([$idA]);

            $this->bdd->commit();
            return true;
        } catch (PDOException $e) {
            $this->bdd->rollBack();
            throw new Exception("Erreur lors de la suppression : " . $e->getMessage());
        }
    }
	
    public function updateAnn($titre, $adresse, $typeCon, $description,$salaire,$duree, $idA)
    {
        $stmt = $this->bdd->prepare("UPDATE Annonce SET Titre = :titre, Adresse = :adresse,
        	TypeCon= :typeCon, description = :description,Salaire=:salaire,Duree=:duree WHERE idAnnonce = :idA");
        $stmt->bindParam(':titre', $titre);
		$stmt->bindParam(':adresse', $adresse);
		$stmt->bindParam(':typeCon', $typeCon);
		$stmt->bindParam(':description',$description);
        $stmt->bindParam(':salaire',$salaire);
        $stmt->bindParam(':duree',$duree);
        $stmt->bindParam(':idA', $idA);
       return $stmt->execute();
    }
    public function getAnnById($idA) {
        $stmt = $this->bdd->prepare('SELECT * FROM Annonce WHERE idAnnonce = ?');
        $stmt->execute([$idA]);
        return $stmt->fetch();
    }
	public function getTitreByCand($idA) {
		$stmt = $this->bdd->prepare('
			SELECT a.titre
			FROM Annonce a
			INNER JOIN Candidature c ON a.idAnnonce = c.idAnnonce
			WHERE c.idCandidature = ?;
		');
		$stmt->execute([$idA]);
		return $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch all titles as an array
	}
	
}