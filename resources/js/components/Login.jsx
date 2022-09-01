import { useState } from "react";
import AuthUser from "./AuthUser";

export default function Login(){
    const {http} = AuthUser();
    const [email,setEmail] = useState();
    const [password,setPassword] = useState();

    const submitFrom = () => {
        console.log(email + " " + password);
        http.post('/login', {email:email, password:password})
            .then((res)=>{
                console.log(res.data)
            })
    }
    return(
        <div className="row justify-content-center pt-5">
            <div className="col-sm-6">
                <div className="card p-4">
                    <div className="form-group">
                        <label>Email address:</label>
                        <input type="email" className="form-control" id="email" onChange={e => setEmail(e.target.value)} />
                    </div>
                    <div className="form-group">
                        <label>Password:</label>
                        <input type="password" className="form-control" id="pwd" onChange={e => setPassword(e.target.value)} />
                    </div>
                    
                    <button onClick={submitFrom} type="button" className="btn btn-primary mt-4">Login</button>
                </div>
            </div>
        </div>
    )
}