/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entities;

import java.util.Objects;

/**
 *
 * @author SDIRI Yasmine
 */
public class Produit implements Comparable <Produit> {
       
  private String reference_p, nom_p,type_p,marque_p,image_p,description_p,couleur,categorie;
  private float prix_p ;
  private int quantite_p ;
  private int quantite_v ;
  
    public Produit() {
    }

    public Produit(String ref , String nom, String type, String marque, float prix, int stock, String img, String desc, int quantite_v, String couleur, String categorie) {
        this.reference_p=ref;
        this.nom_p=nom;
        this.type_p=type;
        this.marque_p=marque;
        this.prix_p=prix;
        this.quantite_p=stock;
        this.image_p=img;
        this.description_p=desc;
        this.quantite_v=quantite_v;
        this.couleur=couleur;
        this.categorie=categorie;
      
    }
     public Produit(String ref ) {
        this.reference_p=ref;
        
      
    }

    public String getref() {
        return reference_p;
    }

    public void setref(String ref) {
        this.reference_p = ref;
    }

    public String getnom() {
        return nom_p;
    }
  public void setnom(String nom) {
        this.nom_p = nom;
    }
    public void settype(String type) {
        this.type_p = type;
    }
     public String gettype() {
        return nom_p;
    }

    public String getMarque_p() {
        return marque_p;
    }

    public void setMarque_p(String marque_p) {
        this.marque_p = marque_p;
    }

    public float getPrix_p() {
        return prix_p;
    }

    public void setPrix_p(float prix_p) {
        this.prix_p = prix_p;
    }

    public int getQuantite_p() {
        return quantite_p;
    }

    public void setQuantite_p(int quantite_p) {
        this.quantite_p = quantite_p;
    }

    public String getImage_p() {
        return image_p;
    }

    public void setImage_p(String image_p) {
        this.image_p = image_p;
    }

    public String getDescription_p() {
        return description_p;
    }

    public void setDescription_p(String description_p) {
        this.description_p = description_p;
    }

    public int getQuantite_v() {
        return quantite_v;
    }

    public void setQuantite_v(int quantite_v) {
        this.quantite_v = quantite_v;
    }

    public String getCouleur() {
        return couleur;
    }

    public void setCouleur(String couleur) {
        this.couleur = couleur;
    }
     public String getCategorie() {
        return categorie;
    }

    public void setCategorie(String categorie) {
        this.categorie = categorie;
    }

    @Override
    public String toString() {
        return "Produit{" + "reference_p=" + reference_p + ", nom_p=" + nom_p + ", type_p=" + type_p + ", marque_p=" + marque_p + ", prix_p=" + prix_p + ", quantite_p=" + quantite_p + ", image_p=" + image_p + ", description_p=" + description_p + ", quantite_v=" + quantite_v + ", couleur=" + couleur + ", categorie=" + categorie + '}';
    }

 @Override
    public int hashCode() {
        int hash = 3;
        return hash;
    }

    @Override
    public boolean equals(Object obj) {
        if (this == obj) {
            return true;
        }
        if (obj == null) {
            return false;
        }
        if (getClass() != obj.getClass()) {
            return false;
        }
        final Produit other = (Produit) obj;
        if (this.quantite_v != other.quantite_v) {
            return false;
        }
        if (!Objects.equals(this.marque_p, other.marque_p)) {
            return false;
        }
        if (!Objects.equals(this.categorie, other.categorie)) {
            return false;
        }
        return true;
    }

    @Override
    public int compareTo(Produit p) {
        return marque_p.compareTo(p.getMarque_p());
        //throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

   
   

  
    
    
}
