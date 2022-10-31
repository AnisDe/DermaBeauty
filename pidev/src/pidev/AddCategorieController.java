/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pidev;

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
import javafx.scene.control.TextField;
import javafx.scene.input.MouseEvent;

/**
 * FXML Controller class
 *
 * @author SDIRI Yasmine
 */
public class AddCategorieController implements Initializable {

    @FXML
    private TextField reference;
    @FXML
    private TextField nom;

    /**
     * Initializes the controller class.
     */
      String query = null;
    Connection connection = null;
    ResultSet resultSet = null;
    PreparedStatement preparedStatement;
    //User user = null;
    private boolean update;
    String refCat;
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void save(MouseEvent event) {
         connection = MaConnection.getInstance().getConnection();
        String ref = reference.getText();
        String n = nom.getText();
        
        

        if (ref.isEmpty() || n.isEmpty()) {
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
    }
    private void getQuery() {

        if (update == false) {
            
            query = "INSERT INTO `categorie_p` (reference_c, nom_c) VALUES (?,?)";

        }else{
            query =  "UPDATE `categorie_p` SET "
                    + "reference_c=?,"                   
                    + "nom_c= ? WHERE reference_c = '"+refCat+"'";
                   
        }

    }
   private void insert() {

        try {

            preparedStatement = connection.prepareStatement(query);
            preparedStatement.setString(1, reference.getText());
            preparedStatement.setString(2, nom.getText());
          
          
            preparedStatement.execute();

        } catch (SQLException ex) {
            Logger.getLogger(AddProduitController.class.getName()).log(Level.SEVERE, null, ex);
            System.out.println("erreur");
        }

    }

    void setTextField(String ref, String n ) {

       // studentId = id;
        refCat=ref;
        reference.setText(ref);
        nom.setText(n);
       

    }

    void setUpdate(boolean b) {
        this.update = b;

    }

    
}
