package com.selenit.virtualqueue.printer;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
import java.awt.Font;
import java.io.IOException;
import javax.print.PrintException;

import javax.print.attribute.HashPrintRequestAttributeSet;
import javax.print.attribute.PrintRequestAttributeSet;
import javax.print.attribute.standard.Copies;
import javax.print.attribute.standard.MediaSize;
import javax.print.attribute.standard.MediaPrintableArea;

import java.awt.Graphics;
import java.awt.print.PageFormat;
import java.awt.print.Printable;
import java.text.SimpleDateFormat;
import java.util.Date;

import javax.print.DocFlavor;
import javax.print.DocPrintJob;
import javax.print.PrintService;
import javax.print.PrintServiceLookup;
import javax.print.SimpleDoc;
import javax.swing.ImageIcon;

public class PrintText {

    public static void main(String[] args) throws PrintException, IOException {
        PrintService service = PrintServiceLookup.lookupDefaultPrintService();
        DocPrintJob job = service.createPrintJob();
        DocFlavor flavor = DocFlavor.SERVICE_FORMATTED.PRINTABLE;
        PrintRequestAttributeSet pras = new HashPrintRequestAttributeSet();
        pras.add(new Copies(1));
        int width = Math.round(MediaSize.ISO.A4.getX(MediaSize.MM));
        int height = Math.round(MediaSize.ISO.A4.getY(MediaSize.MM));
        pras.add(new MediaPrintableArea(10, 10, width - 20, height - 20, MediaPrintableArea.MM));

        MyPrintable p = new MyPrintable();
        p.args = args;

        SimpleDoc doc = new SimpleDoc(p, flavor, null);
        job.print(doc, pras);
    }
}

class MyPrintable implements Printable {

    ImageIcon printImage = new javax.swing.ImageIcon("../global/temp/test.png");
    //ImageIcon printImage = new javax.swing.ImageIcon("test.png");
    String[] args;

    public int print(Graphics g, PageFormat pf, int pageIndex) {

        g.translate((int) (pf.getImageableX()), (int) (pf.getImageableY()));
        if (pageIndex == 0) {
            SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyy hh:mm:ss");
            
            g.setFont(new Font("TimesRoman", Font.CENTER_BASELINE, 20));
            g.drawString(formatPrint(args[1]), 0, 20);
            
            g.setFont(new Font("TimesRoman", Font.CENTER_BASELINE, 10));
            g.drawString(formatPrint(args[0]), 0, 30);
            
            g.setFont(new Font("TimesRoman", Font.CENTER_BASELINE, 8));
            g.drawString("Utilice el siguiente enlace", 0, 46);
            g.drawString("para seguimiento online", 0, 56);
            g.drawImage(printImage.getImage(), 0, 60, null);
            g.drawString(sdf.format(new Date()), 0, 195);
            
            g.drawString("O ingrese " + formatPrint(args[2]), 0, 220);
            g.drawString("en " + formatPrint(args[3]), 0, 230);
            return Printable.PAGE_EXISTS;
        }
        return Printable.NO_SUCH_PAGE;
    }
    
    private String formatPrint(String str){
        str = str.replaceAll("&aacute;", "a");
        str = str.replaceAll("&eacute;", "e");
        str = str.replaceAll("&iacute;", "i");
        str = str.replaceAll("&oacute;", "o");
        str = str.replaceAll("&uacute;", "u");
        str = str.replaceAll("&ntilde;", "n");
        str = str.replaceAll("&Ntilde;", "N");
        
        str = str.replaceAll("á", "a");
        str = str.replaceAll("é", "e");
        str = str.replaceAll("í", "i");
        str = str.replaceAll("ó", "o");
        str = str.replaceAll("ú", "u");
        str = str.replaceAll("ñ", "n");
        str = str.replaceAll("Ñ", "n");
        
        return str;
    }
}
