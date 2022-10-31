/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Interfaces;

import Entities.Categorie;
import java.sql.SQLException;
import java.util.List;

/**
 *
 * @author SDIRI Yasmine
 */
public interface IServiceCategorie {
    
     public void addCategorie(Categorie c) throws SQLException;

    public List<Categorie> getCategories() throws SQLException;

  //  public Categorie getById(String ref) throws SQLException;

  //  public void deleteCategorie(Categorie c) throws SQLException;

    public void deleteCategorie(String ref) throws SQLException;

    public void updateCategorie(Categorie c) throws SQLException;
    
  //  public boolean getCategorie(Categorie c) throws SQLException;
}
