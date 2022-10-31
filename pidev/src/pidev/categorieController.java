/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pidev;

import Entities.Categorie;
import Services.ServiceCategorie;
import Utils.MaConnection;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.HBox;
import javafx.stage.Stage;
import javafx.stage.StageStyle;
import javafx.util.Callback;

/**
 * FXML Controller class
 *
 * @author SDIRI Yasmine
 */
public class categorieController implements Initializable {

    @FXML
    private TableView<Categorie> CategorieTable;
    @FXML
    private TableColumn<Categorie, String> reference;
    @FXML
    private TableColumn<Categorie, String> nom;
    @FXML
    private TableColumn<Categorie, String> editCol;
    String query = null;
    Connection connection = null ;
    PreparedStatement preparedStatement = null ;
    ResultSet resultSet = null ;
    Categorie categorie = null ;
    ServiceCategorie sc= new ServiceCategorie();
    
    ObservableList<Categorie>  CategorieList = FXCollections.observableArrayList();

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        
    try {
           loadDate();
       } catch (SQLException ex) {
           Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
       }
    }    
    private void close(java.awt.event.MouseEvent event) {
        Stage stage = (Stage)((Node) event.getSource()).getScene().getWindow();
        stage.close();
    }

    @FXML
    private void refreshTable() throws SQLException {
         CategorieList.clear();
           // UserList=(ObservableList<User>) scU.getUsers();
            query = "SELECT * FROM categorie_p";
            preparedStatement = connection.prepareStatement(query);
            resultSet = preparedStatement.executeQuery();
          while (resultSet.next()){
              Categorie p2 = new Categorie();
            p2.setReference_c(resultSet.getString("reference_c"));
            p2.setNom_c(resultSet.getString("nom_c"));
          
            CategorieList.add(p2);
                 
                CategorieTable.setItems(CategorieList);
    }
    }
    @FXML
    private void getAddView() {
        try {
            Parent parent = FXMLLoader.load(getClass().getResource("add_Categorie.fxml"));
            Scene scene = new Scene(parent);
            Stage secstage = new Stage();
            secstage.setScene(scene);
            secstage.initStyle(StageStyle.UTILITY);
            secstage.show();
        } catch (IOException ex) {
            Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
     private void loadDate() throws SQLException{
        connection = MaConnection.getInstance().getConnection();
         refreshTable();
        reference.setCellValueFactory(new PropertyValueFactory<>("reference_c"));
        nom.setCellValueFactory(new PropertyValueFactory<>("nom_c"));
        
        Callback <TableColumn<Categorie, String>, TableCell<Categorie, String>> cellFoctory = (TableColumn<Categorie, String> param) -> {
            // make cell containing buttons
            final TableCell<Categorie, String> cell = new TableCell<Categorie, String>() {    
               @Override
                public void updateItem(String item, boolean empty) {
                    super.updateItem(item, empty);
                    //that cell created only on non-empty rows
                    if (empty) {
                        setGraphic(null);
                        setText(null);

                    }else {

                        Button deleteIcon = new Button("delete");
                        Button editIcon =  new Button("edit");

                        deleteIcon.setStyle(
                                " -fx-cursor: hand ;"
                                + "-glyph-size:28px;"
                                + "-fx-fill:#ff1744;"
                        );
                        editIcon.setStyle(
                                " -fx-cursor: hand ;"
                                + "-glyph-size:28px;"
                                + "-fx-fill:#00E676;"
                        );
                        deleteIcon.setOnMouseClicked(event -> {
                           try{ 
                                categorie = CategorieTable.getSelectionModel().getSelectedItem();
                                query = "DELETE FROM `categorie_p`  WHERE reference_c = '" + categorie.getReference_c() + "'";
                                connection = MaConnection.getInstance().getConnection();
                                preparedStatement = connection.prepareStatement(query);
                                preparedStatement.execute();
                                refreshTable();
                           } catch (SQLException ex) {
                                Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
                                System.out.println("er");
                                
                           }
                        });
                      editIcon.setOnMouseClicked(event -> {
                            
                            categorie = CategorieTable.getSelectionModel().getSelectedItem();
                            FXMLLoader loader = new FXMLLoader ();
                            loader.setLocation(getClass().getResource("add_Categorie.fxml"));
                            try {
                                loader.load();
                            } catch (IOException ex) {
                                Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
                            }
                            
                            AddCategorieController addCategoriesController = loader.getController();
                            addCategoriesController.setUpdate(true);
                            addCategoriesController.setTextField(categorie.getReference_c(),categorie.getNom_c());
                            Parent parent = loader.getRoot();
                            Stage stage = new Stage();
                            stage.setScene(new Scene(parent));
                            stage.initStyle(StageStyle.UTILITY);
                            stage.show();
                 
                        });
                        HBox managebtn = new HBox(editIcon, deleteIcon);
                        managebtn.setStyle("-fx-alignment:center");
//                        HBox.setMargin(deleteIcon,new Insets(0, 0, 0, 50));
//                        HBox.setMargin(editIcon, new Insets(2, 3, 0, 2));

                        setGraphic(managebtn);

                        setText(null);

    
}
                }
            };
                    return cell;
                    }; 
         editCol.setCellFactory(cellFoctory);
         CategorieTable.setItems(CategorieList);
    }
    }
    

