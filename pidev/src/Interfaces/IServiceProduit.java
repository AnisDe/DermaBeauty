 /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Interfaces;

import Entities.Produit;
import java.sql.SQLException;
import java.util.List;


/**
 *
 * @author SDIRI Yasmine
 */
public interface IServiceProduit {

     public void addProduit(Produit p) throws SQLException;

    public List<Produit> getProduits() throws SQLException;

   // public Produit getById(String ref) throws SQLException;

    //public void deleteProduit(Produit p) throws SQLException;

    public void deleteProduit(String ref) throws SQLException;

    public void updateProduit(Produit p) throws SQLException;
    
   //public boolean getProduit(Produit p) throws SQLException;
     public List<Produit> trierProduitParNom()throws SQLException;
     public void trierProd(List p);
     
     public List<Produit> rechercherProduit(String marque)throws SQLException ;
     public Boolean rechercheProd(Produit p , String marque);
}
