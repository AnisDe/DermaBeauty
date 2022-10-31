/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pidev;


import Entities.Produit;
import Services.ServiceProduit;
import Utils.MaConnection;
import java.awt.event.MouseEvent;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
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
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.ImageView;
import javafx.scene.layout.HBox;
import javafx.stage.Stage;
import javafx.stage.StageStyle;
import javafx.util.Callback;

/**
 * FXML Controller class
 *
 * @author SDIRI Yasmine
 */
public class backController implements Initializable {

   @FXML
    private TableView<Produit> ProduitTable;
    @FXML
    private TableColumn<Produit, String> reference;
    @FXML
    private TableColumn<Produit, String> nom;
    @FXML
    private TableColumn<Produit, String> type;
    @FXML
    private TableColumn<Produit, String> marque;
    @FXML
    private TableColumn<Produit, Float> prix;
    @FXML
    private TableColumn<Produit, Integer> quantite;
    @FXML
    private TableColumn<Produit, String> image;
    @FXML
    private TableColumn<Produit, String> description;
    @FXML
    private TableColumn<Produit, String> categorie;
    @FXML
    private TableColumn<Produit, String> editCol;
      @FXML
    private Button trier;
   
     String query = null;
    Connection connection = null ;
    PreparedStatement preparedStatement = null ;
    ResultSet resultSet = null ;
    Produit produit = null ;
    ServiceProduit sp= new ServiceProduit();
    
    ObservableList<Produit>  ProduitList = FXCollections.observableArrayList();
    List<Produit> produits= new ArrayList();
    @FXML
    private TextField search;
    @FXML
    private Button searchbutton;
  
    

    /**
     * Initializes the controller class.
     */
    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
       try {
           loadDate();
       } catch (SQLException ex) {
           Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
       }
    }    
    private void close(MouseEvent event) {
        Stage stage = (Stage)((Node) event.getSource()).getScene().getWindow();
        stage.close();
    }
     @FXML
    private void getAddView() throws IOException {
        try {
            Parent parent = FXMLLoader.load(getClass().getResource("add_Produit.fxml"));
            Scene scene = new Scene(parent);
            Stage secstage = new Stage();
            secstage.setScene(scene);
            secstage.initStyle(StageStyle.UTILITY);
            secstage.show();
        } catch (IOException ex) {
            Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
        }
       
    }
   
    
    
   /* @FXML
    private void getAddView() {
       try {
            Parent parent = FXMLLoader.load(getClass().getResource("add_Produit.fxml"));
            Scene scene = new Scene(parent);
            Stage secstage = new Stage();
            secstage.setScene(scene);
            secstage.initStyle(StageStyle.UTILITY);
            secstage.show();
        } catch (IOException ex) {
            Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }*/
   /* try {
            Parent parent = FXMLLoader.load(getClass().getResource("addUser.fxml"));
            Scene scene = new Scene(parent);
            Stage secstage = new Stage();
            secstage.setScene(scene);
            secstage.initStyle(StageStyle.UTILITY);
            secstage.show();
        } catch (IOException ex) {
            Logger.getLogger(backUserController.class.getName()).log(Level.SEVERE, null, ex);
        }*/

    @FXML
    private void refreshTable() throws SQLException {
        
        ProduitList.clear();
           // UserList=(ObservableList<User>) scU.getUsers();
            query = "SELECT * FROM produit";
            preparedStatement = connection.prepareStatement(query);
            resultSet = preparedStatement.executeQuery();
          while (resultSet.next()){
              Produit p2 = new Produit();
            p2.setref(resultSet.getString("reference_p"));
            p2.setnom(resultSet.getString("nom_p"));
            p2.settype(resultSet.getString("type_p"));
            p2.setMarque_p(resultSet.getString("marque_p"));
            p2.setPrix_p(resultSet.getFloat("prix_p"));
            p2.setQuantite_p(resultSet.getInt("quantite_p"));
            p2.setImage_p(resultSet.getString("image_p"));
            p2.setDescription_p(resultSet.getString("description_p"));
            //p2.setQuantite_v(resultSet.getInt("quantite_v"));
           // p2.setCouleur(resultSet.getString("couleur"));
            p2.setCategorie(resultSet.getString("categorie"));
           
            ProduitList.add(p2);
                 
                ProduitTable.setItems(ProduitList);
                
            }
           // System.out.println("iciiiiiiiii");
        /* ProduitList.clear();
            ProduitList=(ObservableList<Produit>) sp.getProduits();
            
            ProduitTable.setItems(ProduitList);*/
}
    private void loadDate() throws SQLException{
        connection = MaConnection.getInstance().getConnection();
         refreshTable();
        reference.setCellValueFactory(new PropertyValueFactory<>("reference_p"));
        nom.setCellValueFactory(new PropertyValueFactory<>("nom_p"));
        type.setCellValueFactory(new PropertyValueFactory<>("type_p"));
        marque.setCellValueFactory(new PropertyValueFactory<>("marque_p"));
        prix.setCellValueFactory(new PropertyValueFactory<>("prix_p"));
        quantite.setCellValueFactory(new PropertyValueFactory<>("quantite_p"));
        image.setCellValueFactory(new PropertyValueFactory<>("image_p"));
        description.setCellValueFactory(new PropertyValueFactory<>("description_p"));
        categorie.setCellValueFactory(new PropertyValueFactory<>("categorie"));
        
        Callback <TableColumn<Produit, String>, TableCell<Produit, String>> cellFoctory = (TableColumn<Produit, String> param) -> {
            // make cell containing buttons
            final TableCell<Produit, String> cell = new TableCell<Produit, String>() {    
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
                                produit = ProduitTable.getSelectionModel().getSelectedItem();
                                query = "DELETE FROM `produit`  WHERE reference_p = '" + produit.getref() + "'";
                                connection = MaConnection.getInstance().getConnection();
                                preparedStatement = connection.prepareStatement(query);
                                preparedStatement.execute();
                                refreshTable();
                           } catch (SQLException ex) {
                                Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
                                
                                      
                            }
                        });
                      editIcon.setOnMouseClicked(event -> {
                            
                            produit = ProduitTable.getSelectionModel().getSelectedItem();
                            FXMLLoader loader = new FXMLLoader ();
                            loader.setLocation(getClass().getResource("add_Produit.fxml"));
                            try {
                                loader.load();
                            } catch (IOException ex) {
                                Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
                            }
                            
                            AddProduitController addProduitsController = loader.getController();
                            addProduitsController.setUpdate(true);
                            addProduitsController.setTextField(produit.getref(),produit.getnom(),produit.gettype(),produit.getMarque_p(),produit.getPrix_p(),produit.getQuantite_p(),produit.getImage_p(),produit.getDescription_p(),produit.getCategorie());
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
         ProduitTable.setItems(ProduitList);
    }

    @FXML
    private void categorie(javafx.scene.input.MouseEvent event) throws IOException {
            try {
            Parent parent = FXMLLoader.load(getClass().getResource("back_Categorie.fxml"));
            Scene scene = new Scene(parent);
            Stage secstage = new Stage();
            secstage.setScene(scene);
            secstage.initStyle(StageStyle.UTILITY);
            secstage.show();
        } catch (IOException ex) {
            Logger.getLogger(backController.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    }

    @FXML
    private void trier(javafx.scene.input.MouseEvent event) throws SQLException {
          ProduitList.clear();
              produits=sp.getProduits();
               sp.trierProd(produits);
               for(int i=0;i<produits.size();i++  ) {
             Produit p = new Produit();
            
            p.setref(produits.get(i).getref());
            p.setnom(produits.get(i).getnom());
            p.settype(produits.get(i).gettype());
            p.setMarque_p(produits.get(i).getMarque_p());
            p.setPrix_p(produits.get(i).getPrix_p());
            p.setQuantite_p(produits.get(i).getQuantite_p());
            p.setImage_p(produits.get(i).getImage_p());
            p.setDescription_p(produits.get(i).getDescription_p());
            p.setCategorie(produits.get(i).getCategorie());
           
             
           
             ProduitList.add(p);
            ProduitTable.setItems(ProduitList);
    }
                reference.setCellValueFactory(new PropertyValueFactory<>("reference_p"));
        nom.setCellValueFactory(new PropertyValueFactory<>("nom_p"));
        type.setCellValueFactory(new PropertyValueFactory<>("type_p"));
        marque.setCellValueFactory(new PropertyValueFactory<>("marque_p"));
        prix.setCellValueFactory(new PropertyValueFactory<>("prix_p"));
        quantite.setCellValueFactory(new PropertyValueFactory<>("quantite_p"));
        image.setCellValueFactory(new PropertyValueFactory<>("image_p"));
        description.setCellValueFactory(new PropertyValueFactory<>("description_p"));
        categorie.setCellValueFactory(new PropertyValueFactory<>("categorie"));
        }

    @FXML
    private void search(javafx.scene.input.MouseEvent event) throws SQLException {
          ProduitList.clear();
               String Marque=search.getText();
              produits=sp.getProduits();
               
                for(int i=0;i<produits.size();i++  ) {
                     if(sp.rechercheProd(produits.get(i),Marque)== true){
             Produit p = new Produit();
            
            p.setref(produits.get(i).getref());
            p.setnom(produits.get(i).getnom());
            p.settype(produits.get(i).gettype());
            p.setMarque_p(produits.get(i).getMarque_p());
            p.setPrix_p(produits.get(i).getPrix_p());
            p.setQuantite_p(produits.get(i).getQuantite_p());
            p.setImage_p(produits.get(i).getImage_p());
            p.setDescription_p(produits.get(i).getDescription_p());
            p.setCategorie(produits.get(i).getCategorie());
           
             
           
             ProduitList.add(p);
            ProduitTable.setItems(ProduitList);
    }
                reference.setCellValueFactory(new PropertyValueFactory<>("reference_p"));
        nom.setCellValueFactory(new PropertyValueFactory<>("nom_p"));
        type.setCellValueFactory(new PropertyValueFactory<>("type_p"));
        marque.setCellValueFactory(new PropertyValueFactory<>("marque_p"));
        prix.setCellValueFactory(new PropertyValueFactory<>("prix_p"));
        quantite.setCellValueFactory(new PropertyValueFactory<>("quantite_p"));
        image.setCellValueFactory(new PropertyValueFactory<>("image_p"));
        description.setCellValueFactory(new PropertyValueFactory<>("description_p"));
        categorie.setCellValueFactory(new PropertyValueFactory<>("categorie"));
    }
    } 
}
