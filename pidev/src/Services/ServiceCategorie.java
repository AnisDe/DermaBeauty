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


import Entities.Categorie;
import Interfaces.IServiceCategorie;


/**
 *
 * @author SDIRI Yasmine
 */
public class ServiceCategorie implements IServiceCategorie {
    
       Connection cnx;

    public ServiceCategorie() {
        cnx = MaConnection.getInstance().getConnection();
    }

    @Override
    public void addCategorie(Categorie c) throws SQLException {
        try{       
        Statement stm = cnx.createStatement();
               String query = "INSERT INTO `categorie_p` "
                + "(`reference_c`, `nom_c`)"
                +" VALUES ( '" +c.getReference_c() + "',"
                + " '" + c.getNom_c() + "')";
        stm.executeUpdate(query);}
        //System.out.println("Categorie ajoutée !");}
     
     catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    @Override
    public List<Categorie> getCategories() throws SQLException {
         Statement stm = cnx.createStatement();
        String query = "select * from `categorie_p`";
        ResultSet rst = stm.executeQuery(query);
        List<Categorie> categories = new ArrayList<>();
        while (rst.next()) {
            Categorie c2 = new Categorie();
            c2.setReference_c(rst.getString("reference_c"));
            c2.setNom_c(rst.getString("nom_c"));
            categories.add(c2);
           
        }
     return categories;
     
    }

   /* @Override
    public Categorie getById(String ref) throws SQLException {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }*/

  /*  @Override
    public void deleteCategorie(Categorie c) throws SQLException {
       try {Statement stm = cnx.createStatement();
       String query="DELETE FROM categorie_p WHERE reference_c=" + c.getReference_c();
       stm.executeUpdate(query);
        System.out.println("Categorie supprimée !");}
        catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }*/

    @Override
    public void deleteCategorie(String ref) throws SQLException {
      try { Statement stm = cnx.createStatement();
        String query = "DELETE FROM `categorie_p`  WHERE reference_c = '" + ref + "'";
         stm.executeUpdate(query);}
         catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

    @Override
    public void updateCategorie(Categorie c) throws SQLException {
        try { Statement stm = cnx.createStatement();
        String query = "UPDATE `categorie_p`  SET nom_c='" +c.getNom_c() + "' WHERE reference_c='"+c.getReference_c()+"' ";
         stm.executeUpdate(query);}
         catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    }

   /* @Override
    public boolean getCategorie(Categorie c) throws SQLException {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }*/
    
    
    
    }

   

