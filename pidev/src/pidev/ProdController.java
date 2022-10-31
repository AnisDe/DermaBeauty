/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pidev;

import Entities.Produit;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;

/**
 * FXML Controller class
 *
 * @author SDIRI Yasmine
 */
public class ProdController implements Initializable {

    @FXML
    private Label proName;
    @FXML
    private Label prodPrice;
    @FXML
    private ImageView prodImage;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void clickProd(MouseEvent event) {
    }
     private Produit produit;
  
    
    public void setProduit(Produit p){
  this.produit = p;      
        
        
    }
    
   
    public void setData(Produit p){
      
        proName.setText(p.getnom());
       prodPrice.setText(p.getPrix_p()+" DT");
       
      
    //  prodImage.setImage(new Image(getClass().getResourceAsStream(p.getImage_p())));
         
        
        
        
    }
    
    
}
