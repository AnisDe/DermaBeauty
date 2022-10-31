/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pidev;

import Services.ServiceProduit;
import Entities.Produit;
import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.ResourceBundle;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Insets;
import javafx.scene.control.Button;
import javafx.scene.control.ScrollPane;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.GridPane;

/**
 * FXML Controller class
 *
 * @author SDIRI Yasmine
 */
public class triController implements Initializable {

    @FXML
    private Button prod_id;
    @FXML
    private Button centres_id;
    @FXML
    private Button cart_id;
    @FXML
    private Button connection_id;
    @FXML
    private ScrollPane scrollId;
    @FXML
    private GridPane gridId;

    /**
     * Initializes the controller class.
     */
    private List<Produit> produits = new ArrayList();
    private ServiceProduit sp = new ServiceProduit();
  
     private List<Produit> gettriProd() {
        ArrayList<Produit> tri = new ArrayList();   
    try {
     
        tri.addAll(sp.trierProduitParNom()) ;
    } catch (SQLException ex) {
        System.out.println(ex.getMessage());
        // Logger.getLogger(FXMLDocumentController.class.getName()).log(Level.SEVERE, null, ex);
    }
    return tri;
    }
    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
           produits.addAll(gettriProd());
              //Parent root = FXMLLoader.load(getClass().getResource("FXMLDocument.fxml"));
        int ligne =1;
        int colone = 1;
              
              for(int i=0;i<produits.size();i++){
                  
           
                  try {
                       
            if(colone == 5){
                
                ligne++;
                colone=0;
            }
            
            FXMLLoader fxmlLoader= new FXMLLoader();
           
            fxmlLoader.setLocation(getClass().getResource("prod.fxml"));//recuperer le fichier fxml
             AnchorPane    col = fxmlLoader.load();//recuperer le block du produit
        
            ProdController prodController = fxmlLoader.getController();//recuperer le controller du ficher fxml
            prodController.setData(produits.get(i));//faire le block pour chaque produit de la liste
            //prodController.setProduit(produits.get(i));//prodController.clickProd(event);
                     
                      gridId.add(col, colone++, ligne);//ajouter le block dans le grid
                      GridPane.setMargin(col, new Insets(10));
                  } catch (IOException ex) {
                System.out.println(ex.getMessage());
    // Logger.getLogger(FXMLDocumentController.class.getName()).log(Level.SEVERE, null, ex);
            }
            
               
            
              }
        
// TODO
    }    

   
    
}
