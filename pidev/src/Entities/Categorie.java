/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entities;

/**
 *
 * @author SDIRI Yasmine
 */
public class Categorie {
    
  private String reference_c, nom_c;

    public Categorie() {
    }

  
    public Categorie(String ref, String nom) {
        this.reference_c = ref;
        this.nom_c = nom;
    }

    public String getReference_c() {
        return reference_c;
    }

    public void setReference_c(String reference_c) {
        this.reference_c = reference_c;
    }

    public String getNom_c() {
        return nom_c;
    }

    public void setNom_c(String nom_c) {
        this.nom_c = nom_c;
    }

    @Override
    public String toString() {
        return "Categorie{" + "reference_c=" + reference_c + ", nom_c=" + nom_c + '}';
    }
  
}
