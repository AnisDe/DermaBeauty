/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import java.io.File;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import javax.swing.JFileChooser;
import javax.swing.JOptionPane;


/**
 *
 * @author SDIRI Yasmine
 */
public class MaConnection {

    final static String URL = "jdbc:mysql://127.0.0.1:3306/pidev";
    final static String LOGIN = "root";
    final static String PWD = "";
    static MaConnection instance = null;
    private Connection cnx;
    private MaConnection() {
        
        try {
            cnx = DriverManager.getConnection(URL, LOGIN, PWD);
            System.out.println("cnx etablie  ");
        } catch (SQLException e) {
             System.out.println("erreur de cnx ");    
      

        }
    }

  public static MaConnection getInstance() {
        if (instance == null)
        {
            instance = new MaConnection();
        }
        return instance;
    }
    public  Connection getConnection(){
        return cnx;
    }
    String filename=null; 
    public static String path; 
 public void filen(){
        try{
        JFileChooser chooser = new JFileChooser();
        chooser.setDialogTitle("choisir une image");
        chooser.setApproveButtonText("ajouter une image");
        chooser.showOpenDialog(null);
        File f= chooser.getSelectedFile();
        filename =f.getAbsolutePath();
        this.path=(filename);
        }catch(Exception e){
            System.out.println(e);
            JOptionPane.showMessageDialog(null, "choisir des images");
        
        
 }
        }
    public String getp()
    {
        return path;
    }
}


