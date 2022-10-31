/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;


import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import Utils.MaConnection;


import Entities.Produit;
import Interfaces.IServiceProduit;
import java.util.Collections;


/**
 *
 * @author SDIRI Yasmine
 */
public class ServiceProduit implements IServiceProduit {

      Connection cnx;

    public ServiceProduit() {
        cnx = MaConnection.getInstance().getConnection();
    }

    @Override
     public void addProduit(Produit p) throws SQLException {

     try{   
        Statement stm = cnx.createStatement();
        String query ="INSERT INTO produit (reference_p, nom_p,type_p, marque_p, prix_p, quantite_p, image_p,description_p, quantite_v, couleur) VALUES ('" + p.getref() + "','" + p.getnom() +  "','" + p.gettype() + "','" + p.getMarque_p() + "','" + p.getPrix_p()+ "','" + p.getQuantite_p() + "','" + p.getImage_p() + "','" + p.getDescription_p() + "','" + p.getQuantite_v() + "','" + p.getCouleur() + "')";
        stm.executeUpdate(query);}
       // System.out.println("Produit ajouté !");}
     
     catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }
   

    @Override
    public List<Produit> getProduits() throws SQLException {
        
        Statement stm = cnx.createStatement();
        String query = "select * from `produit`";
        ResultSet rst = stm.executeQuery(query);
        List<Produit> produits = new ArrayList<>();
        while (rst.next()) {
            Produit p2 = new Produit();
            p2.setref(rst.getString("reference_p"));
            p2.setnom(rst.getString("nom_p"));
            p2.settype(rst.getString("type_p"));
            p2.setMarque_p(rst.getString("marque_p"));
            p2.setPrix_p(rst.getFloat("prix_p"));
            p2.setQuantite_p(rst.getInt("quantite_p"));
            p2.setImage_p(rst.getString("image_p"));
            p2.setDescription_p(rst.getString("description_p"));
            p2.setQuantite_v(rst.getInt("quantite_v"));
            p2.setCouleur(rst.getString("couleur"));
            p2.setCategorie(rst.getString("categorie"));
            produits.add(p2);
            
        }
     return produits;
     
    }

   /* @Override
    public Produit getById(String ref) throws SQLException {
       
        Statement stm = cnx.createStatement();
        String query = "SELECT FROM produit WHERE reference_p='"+ref+'"';
        ResultSet rst = stm.executeQuery(query);
        Produit p=new Produit();
         p.setref(rst.getString("reference_p"));
            p.setnom(rst.getString("nom_p"));
            p.settype(rst.getString("type_p"));
            p.setMarque_p(rst.getString("marque_p"));
            p.setPrix_p(rst.getFloat("prix_p"));
            p.setQuantite_p(rst.getInt("quantite_p"));
            p.setImage_p(rst.getString("image_p"));
            p.setDescription_p(rst.getString("description_p"));
            p.setQuantite_v(rst.getInt("quantite_v"));
            p.setCouleur(rst.getString("couleur"));
            p.setCategorie(rst.getString("categorie"));
            System.out.print(p);
             return p;
       
       
    }*/

   /* @Override
    public void deleteProduit(Produit p) throws SQLException {
       
        try {
        Statement stm = cnx.createStatement();
       String query="DELETE FROM produit WHERE reference_p=" + p.getref();
       stm.executeUpdate(query);
       System.out.println("Produit supprimé !");}
        
        catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }*/

    @Override
    public void deleteProduit(String ref) throws SQLException {
        
        try{ Statement stm = cnx.createStatement();
         String query="DELETE FROM `produit`  WHERE reference_p = '" + ref + "'";
         stm.executeUpdate(query);
        }
        
          catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
        
    }

    @Override
    public void updateProduit(Produit p) throws SQLException {
       try {
          Statement stm = cnx.createStatement();
          String query = "UPDATE `produit` SET nom_p ='"+p.getnom()+"',type_p='"+p.gettype()+"',marque_p='"+p.getMarque_p()+"',prix_p='"+p.getPrix_p()+"',quantite_p='"+p.getQuantite_p()+"', image_p='"+p.getImage_p()+"', description_p='"+p.getDescription_p()+"', quantite_v='"+p.getQuantite_v()+"', couleur='"+p.getCouleur()+"' WHERE reference_p='"+p.getref()+"' ";
         stm.executeUpdate(query);
       }
         catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

   /* @Override
    public boolean getProduit(Produit p) throws SQLException {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }
*/
      @Override
    public List<Produit> trierProduitParNom() throws SQLException  {
        
            List<Produit> produits = getProduits();
     //  Collections.sort(users, new ComparerParNom());
             produits.sort((Produit p1, Produit p2) -> {
           return p1.getMarque_p().compareTo(p2.getMarque_p());   });
           // System.out.println(produits);
           return produits;
        }
    @Override
      public void trierProd(List p){
          Collections.sort(p);
      }
    
       @Override
    public List<Produit> rechercherProduit(String marque) throws SQLException {
          List<Produit> produits = getProduits();
          List<Produit> prods= new ArrayList();
        for (int i=0;i<produits.size();i++){
            
            if(produits.get(i).getMarque_p().equals(marque))
           // System.out.println("le produit existe");
             // System.out.println(produits.get(i).toString());
            prods.add(produits.get(i));
              
        }
      //  System.out.println("le produit n existe pas");
       // return false;
        return prods;
        }
    
      @Override
     public Boolean rechercheProd(Produit p , String marque) {
       
     
         if (p.getMarque_p().equals(marque))
         { 
             return true;
         } 
     
     return false;
    }
}
