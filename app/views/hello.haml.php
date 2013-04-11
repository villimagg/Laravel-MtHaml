!!!
%html.no-js{:lang => "en"}

    %head

        %meta{:charset => "utf-8"}

        %title= 'This is HAML'
        %meta{:name => "description", :content => ""}
        %meta{:name => "viewport", :content => "width=device-width, initial-scale=1"}

    %body
        %section.header
            %h1 Hello and welcome
            
        .container
            %p 
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                sed diam nonummy nibh euismod tincidunt ut laoreet dolore 
                magna aliquam erat volutpat. Ut wisi enim ad minim veniam, 
                quis nostrud exerci tation ullamcorper suscipit lobortis 
                nisl ut aliquip
            
            %ul
                - foreach($fruit as $f)
                    %li.fruit
                        = $f
                
            
            