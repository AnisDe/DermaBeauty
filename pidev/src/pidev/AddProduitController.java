/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pidev;

import Entities.Produit;
import Utils.MaConnection;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.scene.input.MouseEvent;

/**
 * FXML Controller class
 *
 * @author SDIRI Yasmine
 */
public class AddProduitController implements Initializable {

    @FXML
    private TextField reference;
    @FXML
    private TextField nom;
    @FXML
    private TextField type;
    @FXML
    private TextField marque;
    @FXML
    private TextField prix;
    @FXML
    private TextField quantite;
    @FXML
    private TextField image;
    @FXML
    private TextField description;
    @FXML
    private TextField categorie;

    /**
     * Initializes the controller class.
     */
    String query = null;
    Connection connection = null;
    ResultSet resultSet = null;
    PreparedStatement preparedStatement;
    //User user = null;
    private boolean update;
    String refProd;
    @FXML
    private Button iporter;
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void save(MouseEvent event) {
        
        connection = MaConnection.getInstance().getConnection();
        String ref = reference.getText();
        String n = nom.getText();
        String tp = type.getText();
        String mq = marque.getText();
        String px = prix.getText();
        String stock = quantite.getText();
        String img = image.getText();
        String desc = description.getText();
        String cat = categorie.getText();
        

        if (ref.isEmpty() || n.isEmpty() || tp.isEmpty() || mq.isEmpty()  || px.isEmpty()  || stock.isEmpty()  || img.isEmpty() || desc.isEmpty() ) {
            Alert alert = new Alert(Alert.AlertType.ERROR);
            alert.setHeaderText(null);
            alert.setContentText("Please Fill All DATA");
            alert.showAndWait();

        } else {
            getQuery();
            insert();
            clean();

        }
    }

    @FXML
    private void clean() {
         reference.setText(null);
        nom.setText(null);
        type.setText(null);
        marque.setText(null);
        prix.setText(null);
        quantite.setText(null);
        image.setText(null);
        description.setText(null);
        categorie.setText(null);
        
    }
    

 private void getQuery() {

        if (update == false) {
            
            query = "INSERT INTO `produit` (reference_p, nom_p,type_p, marque_p, prix_p, quantite_p, image_p,description_p,categorie) VALUES (?,?,?,?,?,?,?,?,?)";

        }else{
            query = "UPDATE `produit` SET "
                    + "reference_p=?,"
                    + "nom_p=?,"
                    + "type_p=?,"
                    + "marque_p=?,"
                    + "prix_p=?,"
                    + "quantite_p=?,"
                    + "image_p=?,"
                    + "description_p=?,"
                    + "categorie= ? WHERE reference_p = '"+refProd+"'";
        }

    }
   private void insert() {

        try {

            preparedStatement = connection.prepareStatement(query);
            preparedStatement.setString(1, reference.getText());
            preparedStatement.setString(2, nom.getText());
            preparedStatement.setString(3, type.getText());
            preparedStatement.setString(4, marque.getText());
            preparedStatement.setString(5, prix.getText());
            preparedStatement.setString(6, quantite.getText());
            preparedStatement.setString(7, image.getText());
            preparedStatement.setString(8, description.getText());
            preparedStatement.setString(9, categorie.getText());
          
            preparedStatement.execute();

        } catch (SQLException ex) {
            Logger.getLogger(AddProduitController.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    void setTextField(String ref, String n, String tp , String mq, float px, int stock, String img, String desc, String cat ) {

       // studentId = id;
        refProd=ref;
        reference.setText(ref);
        nom.setText(n);
        type.setText(tp);
        marque.setText(mq);
        prix.setText(String.valueOf(px));
        quantite.setText(String.valueOf(stock));
        image.setText(img);
        description.setText(desc);
        categorie.setText(cat);

    }

    void setUpdate(boolean b) {
        this.update = b;

    }

    @FXML
    private void importer(MouseEvent event) {
        
        //connection = MaConnection.getInstance().getConnection();
       MaConnection instance = MaConnection.getInstance();
        instance.filen();
        String vpath= instance.getp();
        if(vpath==null){
        }else
        {
            image.setText(vpath);
        }
    }

   


}
